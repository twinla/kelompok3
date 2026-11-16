<?php

namespace App\Http\Controllers;

use App\Models\LibraryEntry;
use App\Models\Story;
use App\Models\StoryComment;
use App\Models\StoryRating;
use App\Models\UserFollow;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StoryPageController extends Controller
{
    public function show(Story $story): View
    {
        $isOwner = auth()->check() && (int) auth()->id() === (int) $story->user_id;
        if ($story->status !== 'published' && !$isOwner) {
            abort(404);
        }

        $story->load(['user', 'characters']);
        $chapters = $story->chapters()
            ->when(!$isOwner, fn ($query) => $query->where('status', 'published'))
            ->orderBy('chapter_number')
            ->get();

        $comments = $story->comments()
            ->with('user')
            ->latest()
            ->paginate(8, ['*'], 'comments_page');

        $isLiked = auth()->check() && $story->likes()->where('user_id', auth()->id())->exists();
        $userRating = auth()->check()
            ? $story->ratings()->where('user_id', auth()->id())->value('rating')
            : null;
        $averageRating = (float) ($story->ratings()->avg('rating') ?? 0);
        $ratingCount = $story->ratings()->count();
        $libraryEntry = auth()->check()
            ? LibraryEntry::where('user_id', auth()->id())->where('story_id', $story->id)->first()
            : null;
        $isFollowingAuthor = auth()->check() && $story->user_id
            ? UserFollow::where('follower_id', auth()->id())->where('followed_id', $story->user_id)->exists()
            : false;

        $likeCount = $story->likes()->count();

        return view('stories.show', compact(
            'story', 'isOwner', 'chapters', 'comments', 'isLiked', 'userRating',
            'averageRating', 'ratingCount', 'libraryEntry', 'isFollowingAuthor', 'likeCount'
        ));
    }
}
