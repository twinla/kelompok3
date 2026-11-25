<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryComment;
use App\Models\StoryLike;
use App\Models\StoryRating;
use App\Models\UserFollow;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function toggleLike(Request $request, Story $story): RedirectResponse
    {
        abort_unless($story->status === 'published', 404);
        $like = StoryLike::where('user_id', $request->user()->id)
            ->where('story_id', $story->id)->first();

        if ($like) {
            $like->delete();
            $message = 'Tanda suka dihapus.';
        } else {
            StoryLike::create(['user_id' => $request->user()->id, 'story_id' => $story->id]);
            $message = 'Kamu menyukai cerita ini.';
        }
        return back()->with('success', $message);
    }

    public function comment(Request $request, Story $story): RedirectResponse
    {
        abort_unless($story->status === 'published', 404);
        $data = $request->validate(['content' => ['required', 'string', 'min:2', 'max:2000']]);
        StoryComment::create([
            'user_id' => $request->user()->id,
            'story_id' => $story->id,
            'content' => $data['content'],
        ]);
        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function deleteComment(Request $request, Story $story, StoryComment $comment): RedirectResponse
    {
        abort_unless((int) $comment->story_id === (int) $story->id, 404);
        $isCommentAuthor = (int) $comment->user_id === (int) $request->user()->id;
        $isStoryOwner = $story->user_id !== null && (int) $story->user_id === (int) $request->user()->id;
        abort_unless($isCommentAuthor || $isStoryOwner, 403);
        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    public function rate(Request $request, Story $story): RedirectResponse
    {
        abort_unless($story->status === 'published', 404);
        $data = $request->validate(['rating' => ['required', 'integer', 'min:1', 'max:5']]);
        StoryRating::updateOrCreate(
            ['user_id' => $request->user()->id, 'story_id' => $story->id],
            ['rating' => $data['rating']]
        );
        return back()->with('success', 'Penilaian kamu berhasil disimpan.');
    }

    public function toggleFollow(Request $request, User $user): RedirectResponse
    {
        abort_if((int) $request->user()->id === (int) $user->id, 422, 'Kamu tidak bisa mengikuti akun sendiri.');
        $follow = UserFollow::where('follower_id', $request->user()->id)
            ->where('followed_id', $user->id)->first();

        if ($follow) {
            $follow->delete();
            $message = 'Kamu berhenti mengikuti penulis ini.';
        } else {
            UserFollow::create(['follower_id' => $request->user()->id, 'followed_id' => $user->id]);
            $message = 'Kamu sekarang mengikuti penulis ini.';
        }
        return back()->with('success', $message);
    }
}
