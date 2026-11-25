<?php

namespace App\Http\Controllers;

use App\Models\ReadingProgress;
use App\Models\Story;
use App\Models\StoryChapter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ChapterController extends Controller
{
    public function create(Story $story): View
    {
        Gate::authorize('update', $story);
        return view('chapters.create', compact('story'));
    }

    public function store(Request $request, Story $story): RedirectResponse
    {
        Gate::authorize('update', $story);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'content' => ['required', 'string', 'min:20'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $chapter = DB::transaction(function () use ($story, $data) {
            $lockedStory = Story::query()->whereKey($story->id)->lockForUpdate()->firstOrFail();
            $nextNumber = ((int) $lockedStory->chapters()->max('chapter_number')) + 1;
            return $lockedStory->chapters()->create([
                ...$data,
                'chapter_number' => $nextNumber,
                'published_at' => $data['status'] === 'published' ? now() : null,
            ]);
        });

        return redirect()->route('chapters.read', [$story, $chapter])
            ->with('success', 'Bab berhasil ditambahkan.');
    }

    public function edit(Story $story, StoryChapter $chapter): View
    {
        Gate::authorize('update', $story);
        $this->ensureChapterBelongsToStory($story, $chapter);
        return view('chapters.edit', compact('story', 'chapter'));
    }

    public function update(Request $request, Story $story, StoryChapter $chapter): RedirectResponse
    {
        Gate::authorize('update', $story);
        $this->ensureChapterBelongsToStory($story, $chapter);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'content' => ['required', 'string', 'min:20'],
            'status' => ['required', 'in:draft,published'],
        ]);
        $data['published_at'] = $data['status'] === 'published'
            ? ($chapter->published_at ?? now())
            : null;
        $chapter->update($data);

        // Sinkronkan kolom legacy stories.content ketika Chapter 1 diedit dari Chapter Manager.
        if ((int) $chapter->chapter_number === 1) {
            $story->update(['content' => $data['content']]);
        }

        return redirect()->route('stories.show', $story)->with('success', 'Bab berhasil diperbarui.');
    }

    public function destroy(Story $story, StoryChapter $chapter): RedirectResponse
    {
        Gate::authorize('update', $story);
        $this->ensureChapterBelongsToStory($story, $chapter);
        $chapter->delete();

        return redirect()->route('stories.show', $story)->with('success', 'Bab berhasil dihapus.');
    }

    public function read(Story $story, StoryChapter $chapter): View
    {
        $this->ensureChapterBelongsToStory($story, $chapter);
        $isOwner = auth()->check() && (int) auth()->id() === (int) $story->user_id;

        if ($story->status !== 'published' && !$isOwner) abort(404);
        if ($chapter->status !== 'published' && !$isOwner) abort(404);

        $visibleChapters = $story->chapters()
            ->when(!$isOwner, fn ($query) => $query->where('status', 'published'))
            ->orderBy('chapter_number')
            ->get();

        $previousChapter = $visibleChapters->where('chapter_number', '<', $chapter->chapter_number)->last();
        $nextChapter = $visibleChapters->firstWhere('chapter_number', '>', $chapter->chapter_number);
        $progress = null;

        if (auth()->check()) {
            $progress = ReadingProgress::firstOrNew([
                'user_id' => auth()->id(),
                'story_id' => $story->id,
            ]);
            if ((int) $progress->chapter_id !== (int) $chapter->id) {
                $progress->progress_percent = 0;
                $progress->completed_at = null;
            }
            $progress->chapter_id = $chapter->id;
            $progress->last_read_at = now();
            $progress->save();
        }

        return view('chapters.read', [
            'story' => $story,
            'chapter' => $chapter,
            'visibleChapters' => $visibleChapters,
            'previousChapter' => $previousChapter,
            'nextChapter' => $nextChapter,
            'resumePercent' => request()->boolean('resume') ? (int) ($progress?->progress_percent ?? 0) : 0,
        ]);
    }

    public function saveProgress(Request $request, Story $story, StoryChapter $chapter): JsonResponse
    {
        $this->ensureChapterBelongsToStory($story, $chapter);
        $isOwner = (int) $request->user()->id === (int) $story->user_id;
        if (($story->status !== 'published' || $chapter->status !== 'published') && !$isOwner) {
            abort(404);
        }

        $data = $request->validate([
            'progress_percent' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $lastPublishedNumber = (int) $story->chapters()->where('status', 'published')->max('chapter_number');
        $isComplete = $chapter->status === 'published'
            && $chapter->chapter_number === $lastPublishedNumber
            && $data['progress_percent'] >= 99;

        ReadingProgress::updateOrCreate(
            ['user_id' => $request->user()->id, 'story_id' => $story->id],
            [
                'chapter_id' => $chapter->id,
                'progress_percent' => $data['progress_percent'],
                'last_read_at' => now(),
                'completed_at' => $isComplete ? now() : null,
            ]
        );

        return response()->json(['saved' => true, 'completed' => $isComplete]);
    }

    private function ensureChapterBelongsToStory(Story $story, StoryChapter $chapter): void
    {
        abort_unless((int) $chapter->story_id === (int) $story->id, 404);
    }
}
