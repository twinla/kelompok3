<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class StoryPdfController extends Controller
{
    public function view(Story $story)
    {
        [$pdf, $filename] = $this->makePdf($story);

        return $pdf->stream($filename);
    }

    public function download(Story $story)
    {
        [$pdf, $filename] = $this->makePdf($story);

        return $pdf->download($filename);
    }

    /** @return array{0: mixed, 1: string} */
    private function makePdf(Story $story): array
    {
        // Only published stories are available for public PDF export.
        abort_unless($story->status === 'published', 404);

        $story->loadMissing('user');
        $chapters = $story->chapters()
            ->where('status', 'published')
            ->orderBy('chapter_number')
            ->get();

        // Compatibility for older stories whose text is still stored in stories.content.
        if ($chapters->isEmpty() && filled($story->content)) {
            $chapters = new Collection([
                (object) [
                    'chapter_number' => 1,
                    'title' => 'Bab 1',
                    'content' => $story->content,
                ],
            ]);
        }

        $authorName = $story->user?->name ?: $story->author;
        $pdf = Pdf::loadView('pdf-export.story', [
            'story' => $story,
            'authorName' => $authorName,
            'chapters' => $chapters,
            'exportedAt' => now(),
        ])->setPaper('a4', 'portrait');

        $filename = (Str::slug($story->title) ?: 'talepad-story') . '.pdf';

        return [$pdf, $filename];
    }
}
