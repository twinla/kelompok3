<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryCharacter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class StoryCharacterController extends Controller
{
    public function store(Request $request, Story $story): RedirectResponse
    {
        Gate::authorize('update', $story);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $validated['image'] = $request->file('image')
            ->store('characters/' . $story->id, 'public');

        $story->characters()->create($validated);

        return redirect()->route('stories.show', $story)
            ->with('success', 'Karakter berhasil ditambahkan ke novel!');
    }

    public function destroy(Story $story, StoryCharacter $character): RedirectResponse
    {
        Gate::authorize('update', $story);

        // Memastikan karakter yang diminta memang milik novel pada URL.
        abort_unless((int) $character->story_id === (int) $story->id, 404);

        if ($character->image) {
            Storage::disk('public')->delete($character->image);
        }

        $character->delete();

        return redirect()->route('stories.show', $story)
            ->with('success', 'Karakter berhasil dihapus.');
    }
}
