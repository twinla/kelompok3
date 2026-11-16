<?php

namespace App\Http\Controllers;

use App\Models\LibraryEntry;
use App\Models\Story;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function index(Request $request): View
    {
        $shelf = $request->query('shelf', 'saved');
        if (!in_array($shelf, ['saved', 'want_to_read'], true)) $shelf = 'saved';

        $entries = LibraryEntry::query()
            ->with(['story.user'])
            ->where('user_id', $request->user()->id)
            ->where('shelf', $shelf)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('library.index', compact('entries', 'shelf'));
    }

    public function store(Request $request, Story $story): RedirectResponse
    {
        abort_unless($story->status === 'published', 404);
        $data = $request->validate(['shelf' => ['required', 'in:saved,want_to_read']]);

        LibraryEntry::updateOrCreate(
            ['user_id' => $request->user()->id, 'story_id' => $story->id],
            ['shelf' => $data['shelf']]
        );

        return back()->with('success', $data['shelf'] === 'saved'
            ? 'Novel disimpan ke Saved Books.'
            : 'Novel ditambahkan ke Want to Read.');
    }

    public function destroy(Request $request, LibraryEntry $entry): RedirectResponse
    {
        abort_unless((int) $entry->user_id === (int) $request->user()->id, 403);
        $entry->delete();
        return back()->with('success', 'Novel dihapus dari library.');
    }
}
