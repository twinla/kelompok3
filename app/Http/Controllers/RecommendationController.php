<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RecommendationController extends Controller
{
    public function index(): View
    {
        $preferredGenres = collect();
        if (auth()->check()) {
            $userId = auth()->id();
            $signals = collect();
            $signals = $signals->merge(DB::table('story_likes')
                ->join('stories', 'stories.id', '=', 'story_likes.story_id')
                ->where('story_likes.user_id', $userId)->pluck('stories.genre'));
            $signals = $signals->merge(DB::table('story_ratings')
                ->join('stories', 'stories.id', '=', 'story_ratings.story_id')
                ->where('story_ratings.user_id', $userId)->where('story_ratings.rating', '>=', 4)
                ->pluck('stories.genre'));
            $signals = $signals->merge(DB::table('reading_progress')
                ->join('stories', 'stories.id', '=', 'reading_progress.story_id')
                ->where('reading_progress.user_id', $userId)->pluck('stories.genre'));

            $preferredGenres = $signals->filter()->countBy()->sortDesc()->keys()->take(3)->values();
        }

        $query = Story::query()
            ->with('user')
            ->withCount('likes')
            ->withAvg('ratings', 'rating')
            ->where('status', 'published');

        if ($preferredGenres->isNotEmpty()) {
            $placeholders = implode(',', array_fill(0, $preferredGenres->count(), '?'));
            $query->orderByRaw("CASE WHEN genre IN ({$placeholders}) THEN 0 ELSE 1 END", $preferredGenres->all());
        }

        $stories = $query->orderByDesc('likes_count')
            ->orderByDesc('ratings_avg_rating')
            ->latest()
            ->paginate(12);

        return view('recommendations.index', compact('stories', 'preferredGenres'));
    }
}
