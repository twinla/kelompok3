<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryChapter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StoryController extends Controller
{
    public function random(): RedirectResponse
    {
        $story = Story::where('status', 'published')->inRandomOrder()->first();

        if (!$story) {
            return redirect()->route('stories.index')
                ->with('error', 'Belum ada novel yang diterbitkan.');
        }

        return redirect()->route('stories.show', $story);
    }

    public function create(): View
    {
        return view('stories.create', ['story' => new Story()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'author' => ['required', 'string', 'max:100'],
            'genre' => ['required', 'string', 'max:80'],
            'synopsis' => ['required', 'string', 'max:2000'],
            'content' => ['required', 'string', 'min:20'],
            'status' => ['required', 'in:draft,published'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::lower(Str::random(5));
        $validated['user_id'] = $request->user()->id;
        $initialContent = $validated['content'];

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $story = Story::create($validated);

        // Isi pada form Create Story otomatis menjadi Chapter 1.
        StoryChapter::create([
            'story_id' => $story->id,
            'chapter_number' => 1,
            'title' => 'Chapter 1',
            'content' => $initialContent,
            'status' => $story->status,
            'published_at' => $story->status === 'published' ? now() : null,
        ]);

        return redirect()->route('stories.show', $story)
            ->with('success', 'Novel dan Chapter 1 berhasil dibuat.');
    }

    public function edit(Story $story): View
    {
        Gate::authorize('update', $story);
        return view('stories.edit', compact('story'));
    }

    public function update(Request $request, Story $story): RedirectResponse
    {
        Gate::authorize('update', $story);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'author' => ['required', 'string', 'max:100'],
            'genre' => ['required', 'string', 'max:80'],
            'synopsis' => ['required', 'string', 'max:2000'],
            'content' => ['required', 'string', 'min:20'],
            'status' => ['required', 'in:draft,published'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            if ($story->cover) {
                Storage::disk('public')->delete($story->cover);
            }
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::lower(Str::random(5));
        $story->update($validated);

        // Form Edit Story tetap mengelola isi Chapter 1; chapter berikutnya dikelola terpisah.
        $firstChapter = $story->chapters()->where('chapter_number', 1)->first();
        $chapterData = [
            'title' => $firstChapter?->title ?: 'Chapter 1',
            'content' => $validated['content'],
            'status' => $story->status,
            'published_at' => $story->status === 'published'
                ? ($firstChapter?->published_at ?? now())
                : null,
        ];

        if ($firstChapter) {
            $firstChapter->update($chapterData);
        } else {
            $story->chapters()->create([
                ...$chapterData,
                'chapter_number' => 1,
            ]);
        }

        return redirect()->route('stories.show', $story)
            ->with('success', 'Novel dan Chapter 1 berhasil diperbarui.');
    }

    public function destroy(Story $story): RedirectResponse
    {
        Gate::authorize('delete', $story);

        if ($story->cover) {
            Storage::disk('public')->delete($story->cover);
        }

        foreach ($story->characters as $character) {
            if ($character->image) {
                Storage::disk('public')->delete($character->image);
            }
        }

        $story->delete();

        return redirect()->route('stories.index')->with('success', 'Novel berhasil dihapus.');
    }
}
