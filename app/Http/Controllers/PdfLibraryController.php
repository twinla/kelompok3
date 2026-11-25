<?php

namespace App\Http\Controllers;

use App\Models\PdfDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PdfLibraryController extends Controller
{
    public function index(Request $request): View
    {
        $documents = PdfDocument::query()
            ->where('user_id', $request->user()->id)
            ->latest('uploaded_at')
            ->paginate(10);

        return view('pdf-library.index', compact('documents'));
    }

    public function show(Request $request, PdfDocument $pdfDocument): View
    {
        $this->ensureOwnership($request, $pdfDocument);

        return view('pdf-library.show', compact('pdfDocument'));
    }

    public function store(Request $request): RedirectResponse
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
        ], [
            'pdf.required' => 'Pilih file PDF terlebih dahulu.',
            'pdf.extensions' => 'File harus menggunakan ekstensi .pdf.',
            'pdf.mimes' => 'File yang diunggah harus berupa PDF yang valid.',
            'pdf.mimetypes' => 'Jenis berkas yang diunggah harus terdeteksi sebagai PDF.',
            'pdf.max' => 'Ukuran PDF maksimal 20 MB.',
        ]);

        $file = $validated['pdf'];
        $originalName = basename(str_replace('\\', '/', $file->getClientOriginalName()));
        $originalName = preg_replace('/[\x00-\x1F\x7F]/u', '', $originalName) ?: 'document.pdf';
        $originalName = mb_substr($originalName, 0, 255);

        $storedName = (string) Str::uuid() . '.pdf';
        $directory = 'pdf-documents/' . $request->user()->id;
        $path = $file->storeAs($directory, $storedName, 'local');

        if (!$path) {
            return back()->withInput()->withErrors([
                'pdf' => 'File gagal disimpan. Periksa izin folder storage Laravel.',
            ]);
        }

        try {
            PdfDocument::create([
                'user_id' => $request->user()->id,
                'original_name' => $originalName,
                'file_path' => $path,
                'mime_type' => 'application/pdf',
                'size_bytes' => $file->getSize(),
                'uploaded_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            Storage::disk('local')->delete($path);
            throw $exception;
        }

        return redirect()->route('pdf-library.index')
            ->with('success', 'PDF berhasil diimpor ke Dokumen PDF Saya.');
    }

    public function preview(Request $request, PdfDocument $pdfDocument)
    {
        $this->ensureOwnership($request, $pdfDocument);

        $disk = Storage::disk('local');
        abort_unless($disk->exists($pdfDocument->file_path), 404);

        $safeFilename = $this->safeFilename($pdfDocument->original_name);

        return response()->file($disk->path($pdfDocument->file_path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $safeFilename . '"',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store, max-age=0',
        ]);
    }

    public function download(Request $request, PdfDocument $pdfDocument)
    {
        $this->ensureOwnership($request, $pdfDocument);

        $disk = Storage::disk('local');
        abort_unless($disk->exists($pdfDocument->file_path), 404);

        return $disk->download($pdfDocument->file_path, $pdfDocument->original_name, [
            'Content-Type' => 'application/pdf',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store, max-age=0',
        ]);
    }

    public function destroy(Request $request, PdfDocument $pdfDocument): RedirectResponse
    {
        $this->ensureOwnership($request, $pdfDocument);

        Storage::disk('local')->delete($pdfDocument->file_path);
        $pdfDocument->delete();

        return redirect()->route('pdf-library.index')
            ->with('success', 'Dokumen PDF berhasil dihapus.');
    }

    private function ensureOwnership(Request $request, PdfDocument $pdfDocument): void
    {
        // Return 404 rather than revealing that another user's document exists.
        abort_unless((int) $pdfDocument->user_id === (int) $request->user()->id, 404);
    }

    private function safeFilename(string $originalName): string
    {
        $name = pathinfo($originalName, PATHINFO_FILENAME);
        $safe = Str::slug($name) ?: 'document';

        return $safe . '.pdf';
    }
}
