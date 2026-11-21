<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiscoveryController extends Controller
{
    public function index(Request $request): View
    {
        $genres = Story::query()
            ->where('status', 'published')
            ->whereNotNull('genre')
            ->where('genre', '<>', '')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        $sort = $request->query('sort', 'latest');
        if (!in_array($sort, ['latest', 'popular', 'top_rated', 'title'], true)) {
            $sort = 'latest';
        }

        $storiesQuery = Story::query()
            ->with('user')
            ->withCount('likes')
            ->withAvg('ratings', 'rating')
            ->where('status', 'published')
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = trim($request->string('q')->toString());
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('title', 'like', "%{$keyword}%")
                        ->orWhere('author', 'like', "%{$keyword}%")
                        ->orWhere('genre', 'like', "%{$keyword}%")
                        ->orWhereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', "%{$keyword}%"));
                });
            })
            ->when($request->filled('genre'), fn ($query) => $query->where('genre', $request->query('genre')));

        match ($sort) {
            'popular' => $storiesQuery->orderByDesc('likes_count')->latest(),
            'top_rated' => $storiesQuery->orderByDesc('ratings_avg_rating')->orderByDesc('likes_count'),
            'title' => $storiesQuery->orderBy('title'),
            default => $storiesQuery->latest(),
        };

        // Keep page sizes predictable and prevent unbounded per-page requests.
        $requestedPerPage = $request->query('per_page', 10);
        $perPage = is_scalar($requestedPerPage)
            ? filter_var((string) $requestedPerPage, FILTER_VALIDATE_INT)
            : false;
        if (!in_array($perPage, [5, 10, 20, 40], true)) {
            $perPage = 10;
        }

        $stories = $storiesQuery->paginate($perPage)->withQueryString();

        return view('stories.index', compact('stories', 'genres', 'sort', 'perPage'));
    }
}
