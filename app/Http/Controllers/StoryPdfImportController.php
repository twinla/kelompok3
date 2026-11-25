<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryPdfImport;
use App\Services\TalePadStoryPdfParser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use InvalidArgumentException;
use Throwable;

class StoryPdfImportController extends Controller
{
    public function create(): View
    {
        return view('story-import.create');
    }

    public function downloadTemplate()
    {
        $template = <<<'TALEPAD'
TALEPAD_STORY_IMPORT_V1

TITLE: [Judul cerita, maksimal 150 karakter]
AUTHOR: [Nama penulis, maksimal 100 karakter]
GENRE: [Genre, maksimal 80 karakter]

SYNOPSIS_START
[Tulis sinopsis cerita di sini, maksimal 2.000 karakter. Hapus teks placeholder ini.]
SYNOPSIS_END

CHAPTER_START: 1
CHAPTER_TITLE: [Judul Bab 1, maksimal 160 karakter]
CHAPTER_CONTENT_START
[Tulis isi Bab 1 di sini, minimal 20 karakter. Hapus teks contoh ini.]
CHAPTER_CONTENT_END
CHAPTER_END

CHAPTER_START: 2
CHAPTER_TITLE: [Judul Bab 2, maksimal 160 karakter]
CHAPTER_CONTENT_START
[Tulis isi Bab 2 di sini, minimal 20 karakter. Hapus blok Bab 2 ini jika cerita hanya memiliki satu bab.]
CHAPTER_CONTENT_END
CHAPTER_END

TALEPAD_STORY_END
TALEPAD;

        return response()->streamDownload(
            static function () use ($template): void {
                echo $template;
            },
            'TalePad_Story_Import_Template.txt',
            ['Content-Type' => 'text/plain; charset=UTF-8']
        );
    }

    public function store(Request $request, TalePadStoryPdfParser $parser): RedirectResponse
    {
        $validated = $request->validate([
            'pdf' => [
                'required',
                'file',
                'extensions:pdf',
                'mimes:pdf',
                'mimetypes:application/pdf',
                'max:20480',
            ],
            'status' => ['required', 'in:draft,published'],
        ], [
            'pdf.required' => 'Pilih file PDF naskah cerita terlebih dahulu.',
            'pdf.extensions' => 'File harus menggunakan ekstensi .pdf.',
            'pdf.mimes' => 'File harus berupa dokumen PDF yang valid.',
            'pdf.mimetypes' => 'Isi berkas yang diunggah tidak terdeteksi sebagai PDF.',
            'pdf.max' => 'Ukuran PDF maksimal 20 MB.',
            'status.required' => 'Pilih status cerita.',
            'status.in' => 'Status cerita tidak valid.',
        ]);

        $filePath = $validated['pdf']->getRealPath();
        if (!is_string($filePath) || !is_file($filePath)) {
            return back()->withInput()->withErrors(['pdf' => 'Berkas PDF sementara tidak dapat dibaca. Silakan pilih ulang berkas.']);
        }

        $fileHash = hash_file('sha256', $filePath);
        if (!is_string($fileHash)) {
            return back()->withInput()->withErrors(['pdf' => 'Berkas PDF tidak dapat diverifikasi. Silakan pilih ulang berkas.']);
        }

        $previousImport = StoryPdfImport::query()
            ->where('user_id', $request->user()->id)
            ->where('file_sha256', $fileHash)
            ->with('story')
            ->first();

        if ($previousImport?->story) {
            return redirect()->route('stories.show', $previousImport->story)
                ->with('error', 'File PDF ini sudah pernah diimpor. TalePad membuka cerita hasil impor sebelumnya agar tidak membuat duplikat.');
        }

        try {
            $parsed = $parser->parseFile((string) $filePath);
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->withErrors(['pdf' => $exception->getMessage()]);
        } catch (Throwable $exception) {
            report($exception);
            return back()->withInput()->withErrors([
                'pdf' => 'PDF gagal diproses. Pastikan file mengikuti templat impor cerita TalePad, lalu coba lagi.',
            ]);
        }

        $originalName = basename(str_replace('\\', '/', $validated['pdf']->getClientOriginalName()));
        $originalName = preg_replace('/[\x00-\x1F\x7F]/u', '', $originalName) ?: 'story.pdf';
        $originalName = function_exists('mb_substr') ? mb_substr($originalName, 0, 255, 'UTF-8') : substr($originalName, 0, 255);

        $status = $validated['status'];
        $now = now();

        try {
            $story = DB::transaction(function () use ($request, $parsed, $status, $now, $fileHash, $originalName): Story {
                $slugBase = Str::slug($parsed['title']) ?: 'story';
                $slug = $slugBase . '-' . Str::lower(Str::random(7));

                $story = Story::create([
                    'user_id' => $request->user()->id,
                    'title' => $parsed['title'],
                    'slug' => $slug,
                    'author' => $parsed['author'],
                    'genre' => $parsed['genre'],
                    'cover' => null,
                    'synopsis' => $parsed['synopsis'],
                    // Keep the legacy stories.content field in sync with Chapter 1.
                    'content' => $parsed['chapters'][0]['content'],
                    'status' => $status,
                ]);

                foreach ($parsed['chapters'] as $chapter) {
                    $story->chapters()->create([
                        'chapter_number' => $chapter['number'],
                        'title' => $chapter['title'],
                        'content' => $chapter['content'],
                        'status' => $status,
                        'published_at' => $status === 'published' ? $now : null,
                    ]);
                }

                StoryPdfImport::create([
                    'user_id' => $request->user()->id,
                    'story_id' => $story->id,
                    'original_name' => $originalName,
                    'file_sha256' => $fileHash,
                ]);

                return $story;
            });
        } catch (Throwable $exception) {
            report($exception);
            return back()->withInput()->withErrors([
                'pdf' => 'Data cerita gagal disimpan ke database. Tidak ada cerita yang dibuat; periksa log Laravel untuk detailnya.',
            ]);
        }

        $message = $status === 'published'
            ? 'Cerita dan seluruh bab berhasil diimpor dan diterbitkan.'
            : 'Cerita dan seluruh bab berhasil diimpor sebagai draf. Kamu dapat memeriksanya sebelum diterbitkan.';

        return redirect()->route('stories.show', $story)->with('success', $message);
    }
}
