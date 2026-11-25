<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user): View
    {
        $isOwner = auth()->check() && (int) auth()->id() === (int) $user->id;

        // Eager-load published chapters so word counts do not trigger a query per story.
        $publishedStories = Story::query()
            ->where('user_id', $user->id)
            ->where('status', 'published')
            ->with([
                'chapters' => fn ($query) => $query->where('status', 'published'),
            ])
            ->withCount('likes')
            ->withAvg('ratings', 'rating')
            ->latest()
            ->get();

        $publishedWordCount = $publishedStories->sum(function (Story $story): int {
            preg_match_all('/[\p{L}\p{N}]+/u', strip_tags($story->content ?? ''), $legacyMatches);
            $legacyWords = count($legacyMatches[0]);

            $chapterWords = $story->chapters->sum(function ($chapter): int {
                preg_match_all('/[\p{L}\p{N}]+/u', strip_tags($chapter->content ?? ''), $chapterMatches);
                return count($chapterMatches[0]);
            });

            return max($legacyWords, $chapterWords);
        });

        // Drafts are only loaded for the profile owner and are never exposed publicly.
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

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_avatar' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama profil wajib diisi.',
            'name.max' => 'Nama profil maksimal 100 karakter.',
            'bio.max' => 'Bio maksimal 500 karakter.',
            'avatar.image' => 'File foto profil harus berupa gambar.',
            'avatar.mimes' => 'Foto profil harus berformat JPG, JPEG, PNG, atau WEBP.',
            'avatar.max' => 'Ukuran foto profil maksimal 2 MB.',
        ]);

        $user = $request->user();

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $validated['avatar_path'] = $request->file('avatar')->store('profiles', 'public');
        } elseif ($request->boolean('remove_avatar') && $user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $validated['avatar_path'] = null;
        }

        unset($validated['avatar'], $validated['remove_avatar']);

        $user->update($validated);

        return redirect()
            ->route('authors.show', $user)
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
