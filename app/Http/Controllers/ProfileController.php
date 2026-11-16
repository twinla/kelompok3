<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user): View
    {
        $isOwner = auth()->check() && (int) auth()->id() === (int) $user->id;

        $publishedStories = Story::query()
            ->where('user_id', $user->id)
            ->where('status', 'published')
            ->latest()
            ->get();

        // Hitung jumlah kata dari karya terbit untuk memberi gambaran aktivitas menulis.
        $publishedWordCount = $publishedStories->sum(function (Story $story): int {
            preg_match_all('/[\p{L}\p{N}]+/u', strip_tags($story->content ?? ''), $matches);
            return count($matches[0]);
        });

        // Draft hanya ditampilkan kepada pemilik akun, tidak kepada pengunjung profil.
        $draftStories = $isOwner
            ? Story::query()
                ->where('user_id', $user->id)
                ->where('status', 'draft')
                ->latest()
                ->get()
            : collect();

        return view('profile.show', [
            'profileUser' => $user,
            'isOwner' => $isOwner,
            'publishedStories' => $publishedStories,
            'draftStories' => $draftStories,
            'publishedWordCount' => $publishedWordCount,
        ]);
    }
}
