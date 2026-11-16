<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use App\Models\UserFollow;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user): View
    {
        $isOwner = auth()->check() && (int) auth()->id() === (int) $user->id;
        $publishedStories = Story::query()->where('user_id', $user->id)
            ->where('status', 'published')->withCount('likes')->withAvg('ratings', 'rating')->latest()->get();
        $publishedWordCount = $publishedStories->sum(function (Story $story): int {
            preg_match_all('/[\p{L}\p{N}]+/u', strip_tags($story->content ?? ''), $matches);
            $legacyWords = count($matches[0]);
            $chapterWords = $story->chapters()->where('status', 'published')->get()->sum(function ($chapter): int {
                preg_match_all('/[\p{L}\p{N}]+/u', strip_tags($chapter->content), $matches);
                return count($matches[0]);
            });
            return max($legacyWords, $chapterWords);
        });
        $draftStories = $isOwner
            ? Story::query()->where('user_id', $user->id)->where('status', 'draft')->latest()->get()
            : collect();
        $followersCount = UserFollow::where('followed_id', $user->id)->count();
        $followingCount = UserFollow::where('follower_id', $user->id)->count();
        $isFollowing = auth()->check() && !$isOwner
            ? UserFollow::where('follower_id', auth()->id())->where('followed_id', $user->id)->exists()
            : false;

        return view('profile.show', compact(
            'user', 'isOwner', 'publishedStories', 'publishedWordCount', 'draftStories',
            'followersCount', 'followingCount', 'isFollowing'
        ));
    }
}
