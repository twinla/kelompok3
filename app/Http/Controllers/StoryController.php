<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StoryController extends Controller
{
    // Pencarian berdasarkan judul, nama pena, genre, atau nama akun penulis.
    public function index(Request $request): View
    {
        $stories = Story::query()
            ->with('user')
            ->where('status', 'published')
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = trim($request->string('q')->toString());

                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('title', 'like', "%{$keyword}%")
                        ->orWhere('author', 'like', "%{$keyword}%")
                        ->orWhere('genre', 'like', "%{$keyword}%")
                        ->orWhereHas('user', function ($userQuery) use ($keyword) {
                            $userQuery->where('name', 'like', "%{$keyword}%");
                        });
                });
            })
            ->latest()
            ->get();

        return view('stories.index', compact('stories'));
    }

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
            'content' => ['required', 'string', 'min:50'],
            'status' => ['required', 'in:draft,published'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::lower(Str::random(5));
        $validated['user_id'] = $request->user()->id;

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $story = Story::create($validated);

        return redirect()->route('stories.show', $story)
            ->with('success', 'Novel berhasil ditambahkan!');
    }

    public function show(Story $story): View
    {
        $isOwner = auth()->check()
            && $story->user_id !== null
            && (int) $story->user_id === (int) auth()->id();

        if ($story->status !== 'published' && !$isOwner) {
            abort(404);
        }

        $story->load(['characters', 'user']);

        return view('stories.show', compact('story'));
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
            'content' => ['required', 'string', 'min:50'],
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

        return redirect()->route('stories.show', $story)
            ->with('success', 'Novel berhasil diperbarui!');
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

        return redirect()->route('stories.index')
            ->with('success', 'Novel berhasil dihapus!');
    }
}
