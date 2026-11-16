<?php

namespace App\Http\Controllers;

use App\Models\ReadingProgress;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReadingController extends Controller
{
    public function bookmarks(Request $request): View
    {
        $progressItems = ReadingProgress::query()
            ->with(['story.user', 'chapter'])
            ->where('user_id', $request->user()->id)
            ->whereNull('completed_at')
            ->orderByDesc('last_read_at')
            ->paginate(12);

        return view('reading.bookmarks', compact('progressItems'));
    }

    public function history(Request $request): View
    {
        $progressItems = ReadingProgress::query()
            ->with(['story.user', 'chapter'])
            ->where('user_id', $request->user()->id)
            ->orderByDesc('last_read_at')
            ->paginate(15);

        return view('reading.history', compact('progressItems'));
    }
}
