<?php

use App\Http\Controllers\StoryPdfImportController;
use Illuminate\Support\Facades\Route;

// Import one TalePad-formatted PDF manuscript as a story with chapters.
Route::middleware('auth')->group(function () {
    Route::get('/stories/import-pdf', [StoryPdfImportController::class, 'create'])
        ->name('stories.import-pdf.create');
    Route::get('/stories/import-pdf/template', [StoryPdfImportController::class, 'downloadTemplate'])
        ->name('stories.import-pdf.template');
    Route::post('/stories/import-pdf', [StoryPdfImportController::class, 'store'])
        ->name('stories.import-pdf.store');
});
