<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoryApiController extends Controller
{
    // GET: Menampilkan semua cerita
    public function index()
    {
        $stories = Story::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar cerita berhasil diambil.',
            'data' => $stories
        ], 200);
    }

    // GET: Menampilkan detail cerita berdasarkan ID
    public function show($id)
    {
        $story = Story::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail cerita berhasil diambil.',
            'data' => $story
        ], 200);
    }

    // POST: Menambahkan cerita baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'cover' => 'nullable|string',
            'synopsis' => 'nullable|string',
            'content' => 'nullable|string',
            'status' => 'nullable|string|max:50',
        ]);

        $story = Story::create([
            ...$validated,
            'slug' => Str::slug($validated['title']) . '-' . Str::lower(Str::random(6)),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cerita berhasil ditambahkan.',
            'data' => $story
        ], 201);
    }

    // PUT: Memperbarui cerita berdasarkan ID
    public function update(Request $request, $id)
    {
        $story = Story::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'genre' => 'sometimes|nullable|string|max:100',
            'cover' => 'sometimes|nullable|string',
            'synopsis' => 'sometimes|nullable|string',
            'content' => 'sometimes|nullable|string',
            'status' => 'sometimes|nullable|string|max:50',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . $story->id;
        }

        $story->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cerita berhasil diperbarui.',
            'data' => $story
        ], 200);
    }

    // DELETE: Menghapus cerita berdasarkan ID
    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        $story->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cerita berhasil dihapus.'
        ], 200);
    }
}