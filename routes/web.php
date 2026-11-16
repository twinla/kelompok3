<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoryCharacterController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;

// Halaman publik.
Route::get('/', [StoryController::class, 'index'])->name('stories.index');
Route::get('/randomize', [StoryController::class, 'random'])->name('stories.random');
Route::get('/authors/{user}', [ProfileController::class, 'show'])->name('authors.show');

// Register dan login.
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Pembuatan dan pengelolaan novel hanya untuk pengguna yang login.
Route::middleware('auth')->group(function () {
    Route::get('/stories/create', [StoryController::class, 'create'])->name('stories.create');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::get('/stories/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
    Route::put('/stories/{story}', [StoryController::class, 'update'])->name('stories.update');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');

    Route::post('/stories/{story}/characters', [StoryCharacterController::class, 'store'])
        ->name('stories.characters.store');
    Route::delete('/stories/{story}/characters/{character}', [StoryCharacterController::class, 'destroy'])
        ->name('stories.characters.destroy');
});

// Detail novel tetap publik. Letakkan setelah /stories/create agar tidak tertangkap sebagai slug.
Route::get('/stories/{story}', [StoryController::class, 'show'])->name('stories.show');
