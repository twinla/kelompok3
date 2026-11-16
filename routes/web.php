<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\DiscoveryController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\StoryCharacterController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\StoryPageController;
use Illuminate\Support\Facades\Route;

// Halaman publik dan discovery.
Route::get('/', [DiscoveryController::class, 'index'])->name('stories.index');
Route::get('/stories', [DiscoveryController::class, 'index'])->name('stories.list');
Route::get('/explore', [DiscoveryController::class, 'index'])->name('stories.explore');
Route::get('/randomize', [StoryController::class, 'random'])->name('stories.random');
Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations.index');
Route::get('/authors/{user}', [ProfileController::class, 'show'])->name('authors.show');

// Register, login, logout.
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    // Novel dan galeri karakter.
    Route::get('/stories/create', [StoryController::class, 'create'])->name('stories.create');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::get('/stories/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
    Route::put('/stories/{story}', [StoryController::class, 'update'])->name('stories.update');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
    Route::post('/stories/{story}/characters', [StoryCharacterController::class, 'store'])->name('stories.characters.store');
    Route::delete('/stories/{story}/characters/{character}', [StoryCharacterController::class, 'destroy'])->name('stories.characters.destroy');

    // Chapter management dan progress membaca.
    Route::get('/stories/{story}/chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
    Route::post('/stories/{story}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
    Route::get('/stories/{story}/chapters/{chapter}/edit', [ChapterController::class, 'edit'])->name('chapters.edit');
    Route::put('/stories/{story}/chapters/{chapter}', [ChapterController::class, 'update'])->name('chapters.update');
    Route::delete('/stories/{story}/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    Route::post('/stories/{story}/chapters/{chapter}/progress', [ChapterController::class, 'saveProgress'])->name('chapters.progress');

    // Library, bookmarks, dan reading history.
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::post('/stories/{story}/library', [LibraryController::class, 'store'])->name('library.store');
    Route::delete('/library/{entry}', [LibraryController::class, 'destroy'])->name('library.destroy');
    Route::get('/reading-bookmarks', [ReadingController::class, 'bookmarks'])->name('reading.bookmarks');
    Route::get('/reading-history', [ReadingController::class, 'history'])->name('reading.history');

    // Like, comment, rating, dan follow.
    Route::post('/stories/{story}/like', [InteractionController::class, 'toggleLike'])->name('stories.like');
    Route::post('/stories/{story}/comments', [InteractionController::class, 'comment'])->name('stories.comments.store');
    Route::delete('/stories/{story}/comments/{comment}', [InteractionController::class, 'deleteComment'])->name('stories.comments.destroy');
    Route::post('/stories/{story}/rating', [InteractionController::class, 'rate'])->name('stories.rating');
    Route::post('/authors/{user}/follow', [InteractionController::class, 'toggleFollow'])->name('authors.follow');
});

// Public reading route terakhir agar tidak menangkap /stories/create.
Route::get('/stories/{story}/chapters/{chapter}', [ChapterController::class, 'read'])->name('chapters.read');
Route::get('/stories/{story}', [StoryPageController::class, 'show'])->name('stories.show');
