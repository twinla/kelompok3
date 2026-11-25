<?php

namespace App\Services;

use InvalidArgumentException;
use Smalot\PdfParser\Config;
use Smalot\PdfParser\Parser;
use Throwable;

class TalePadStoryPdfParser
{
    /**
     * Extract and validate a TalePad Story Import V1 PDF.
     * The uploaded file is parsed in-place and is not stored permanently.
     *
     * @return array{title:string,author:string,genre:string,synopsis:string,chapters:array<int,array{number:int,title:string,content:string}>}
     */
    public function parseFile(string $path): array
    {
        try {
            $config = new Config();
            // PDFs are untrusted input. Limit decompression of an individual stream.
            $config->setDecodeMemoryLimit(64 * 1024 * 1024);

            $parser = new Parser([], $config);
            $pdf = $parser->parseFile($path);
            $text = $pdf->getText();
        } catch (Throwable $exception) {
            throw new InvalidArgumentException(
                'PDF tidak dapat dibaca. Pastikan file tidak rusak, tidak diproteksi password, dan berisi teks yang bisa diseleksi.',
                previous: $exception
            );
        }

        if (!is_string($text) || trim($text) === '') {
            throw new InvalidArgumentException(
                'PDF tidak memiliki teks yang dapat dibaca. PDF hasil scan/foto belum didukung; gunakan PDF berbasis teks.'
            );
        }

        if ($this->length($text) > 1_500_000) {
            throw new InvalidArgumentException('Isi PDF terlalu panjang untuk diproses. Batas teks hasil ekstraksi adalah 1.500.000 karakter.');
        }

        return $this->parseText($text);
    }

    /**
     * Public for isolated parser tests; receives text extracted from the PDF.
     *
     * @return array{title:string,author:string,genre:string,synopsis:string,chapters:array<int,array{number:int,title:string,content:string}>}
     */
    public function parseText(string $text): array
    {
        $text = str_replace(["\r\n", "\r", "\f", "\u{00A0}", "\u{200B}"], ["\n", "\n", "\n", ' ', ''], $text);
        $text = preg_replace('/[\t ]+\n/u', "\n", $text) ?? $text;
        $lines = array_map(
            static fn (string $line): string => trim(preg_replace('/[\t ]+/u', ' ', $line) ?? $line),
            explode("\n", $text)
        );

        $start = $this->findLine($lines, 'TALEPAD_STORY_IMPORT_V1');
        $end = $this->findLine($lines, 'TALEPAD_STORY_END');

        if ($start === null || $end === null || $end <= $start) {
            throw new InvalidArgumentException(
                'Format PDF tidak dikenali. Gunakan Templat Impor Cerita TalePad V1 dan jangan mengubah penanda/label teknis format.'
            );
        }

        $storyLines = array_slice($lines, $start + 1, $end - $start - 1);
        $title = $this->readField($storyLines, 'TITLE');
        $author = $this->readField($storyLines, 'AUTHOR');
        $genre = $this->readField($storyLines, 'GENRE');
        $synopsis = $this->extractSection($storyLines, 'SYNOPSIS_START', 'SYNOPSIS_END');

        $this->rejectPlaceholder($title, 'Judul cerita');
        $this->rejectPlaceholder($author, 'Nama penulis');
        $this->rejectPlaceholder($genre, 'Genre');
        $this->rejectPlaceholder($synopsis, 'Sinopsis');

        $chapters = [];
        $lineCount = count($storyLines);

        for ($i = 0; $i < $lineCount; $i++) {
            if (!preg_match('/^CHAPTER_START:\s*(\d+)$/i', $storyLines[$i], $match)) {
                continue;
            }

            $number = (int) $match[1];
            $chapterEnd = null;
            for ($j = $i + 1; $j < $lineCount; $j++) {
                if (strcasecmp($storyLines[$j], 'CHAPTER_END') === 0) {
                    $chapterEnd = $j;
                    break;
                }
                if (preg_match('/^CHAPTER_START:\s*\d+$/i', $storyLines[$j])) {
                    throw new InvalidArgumentException("Penanda CHAPTER_END untuk Bab {$number} tidak ditemukan.");
                }
            }

            if ($chapterEnd === null) {
                throw new InvalidArgumentException("Penanda CHAPTER_END untuk Bab {$number} tidak ditemukan.");
            }

            $block = array_slice($storyLines, $i + 1, $chapterEnd - $i - 1);
            $chapterTitle = $this->readField($block, 'CHAPTER_TITLE');
            $chapterContent = $this->extractSection($block, 'CHAPTER_CONTENT_START', 'CHAPTER_CONTENT_END');
            $chapterContent = $this->normalizeBody($chapterContent);

            $this->rejectPlaceholder($chapterTitle, "Judul Bab {$number}");
            $this->rejectPlaceholder($chapterContent, "Isi Bab {$number}");

            $chapters[] = [
                'number' => $number,
                'title' => $chapterTitle,
                'content' => $chapterContent,
            ];

            $i = $chapterEnd;
        }

        if (count($chapters) === 0) {
            throw new InvalidArgumentException('PDF belum memiliki bab. Tambahkan minimal satu blok CHAPTER_START sampai CHAPTER_END.');
        }

        if (count($chapters) > 100) {
            throw new InvalidArgumentException('Maksimal 100 bab dalam satu kali impor.');
        }

        $numbers = array_column($chapters, 'number');
        if ($numbers !== range(1, count($chapters))) {
            throw new InvalidArgumentException('Nomor bab harus berurutan mulai dari 1 (1, 2, 3, dan seterusnya).');
        }

        if ($this->length($title) > 150) {
            throw new InvalidArgumentException('Judul cerita maksimal 150 karakter.');
        }
        if ($this->length($author) > 100) {
            throw new InvalidArgumentException('Nama penulis maksimal 100 karakter.');
        }
        if ($this->length($genre) > 80) {
            throw new InvalidArgumentException('Genre maksimal 80 karakter.');
        }
        if ($this->length($synopsis) > 2000) {
            throw new InvalidArgumentException('Sinopsis maksimal 2.000 karakter.');
        }

        foreach ($chapters as $chapter) {
            if ($this->length($chapter['title']) > 160) {
                throw new InvalidArgumentException("Judul Bab {$chapter['number']} maksimal 160 karakter.");
            }
            if ($this->length($chapter['content']) < 20) {
                throw new InvalidArgumentException("Isi Bab {$chapter['number']} minimal 20 karakter.");
            }
            if ($this->length($chapter['content']) > 500_000) {
                throw new InvalidArgumentException("Isi Bab {$chapter['number']} terlalu panjang (maksimal 500.000 karakter).");
            }
        }

        return compact('title', 'author', 'genre', 'synopsis', 'chapters');
    }

    /** @param array<int,string> $lines */
    private function findLine(array $lines, string $marker): ?int
    {
        foreach ($lines as $index => $line) {
            if (strcasecmp($line, $marker) === 0) {
                return $index;
            }
        }

        return null;
    }

    /** @param array<int,string> $lines */
    private function readField(array $lines, string $field): string
    {
        $prefix = strtoupper($field) . ':';
        foreach ($lines as $index => $line) {
            if (str_starts_with(strtoupper($line), $prefix)) {
                $value = trim(substr($line, strlen($prefix)));
                if ($value === '' && isset($lines[$index + 1]) && $lines[$index + 1] !== '') {
                    $value = trim($lines[$index + 1]);
                }
                if ($value === '') {
                    throw new InvalidArgumentException("Bagian {$field} belum diisi.");
                }
                return $value;
            }
        }

        throw new InvalidArgumentException("Label {$prefix} tidak ditemukan. Jangan mengubah label pada template.");
    }

    /** @param array<int,string> $lines */
    private function extractSection(array $lines, string $startMarker, string $endMarker): string
    {
        $start = $this->findLine($lines, $startMarker);
        $end = $this->findLine($lines, $endMarker);

        if ($start === null || $end === null || $end <= $start) {
            throw new InvalidArgumentException("Bagian {$startMarker} / {$endMarker} tidak lengkap atau berubah.");
        }

        return trim(implode("\n", array_slice($lines, $start + 1, $end - $start - 1)));
    }

    private function normalizeBody(string $body): string
    {
        $body = trim($body);
        // PDF text extraction often wraps a paragraph at the visual line width.
        // Join single line wraps, but preserve blank lines between paragraphs.
        $body = preg_replace('/(?<!\n)\n(?!\n)/u', ' ', $body) ?? $body;
        $body = preg_replace('/\n{3,}/u', "\n\n", $body) ?? $body;
        $body = preg_replace('/[\t ]{2,}/u', ' ', $body) ?? $body;
        return trim($body);
    }

    private function length(string $value): int
    {
        return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
    }

    private function rejectPlaceholder(string $value, string $label): void
    {
        if ($value === '' || preg_match('/^\[[^\]]+\]$/u', trim($value))) {
            throw new InvalidArgumentException("{$label} masih kosong atau masih berisi teks contoh dari templat.");
        }
    }
}
