<?php

use App\Http\Controllers\PdfLibraryController;
use App\Http\Controllers\StoryPdfController;
use Illuminate\Support\Facades\Route;

// Public PDF export: only published stories can be viewed or downloaded.
Route::get('/stories/{story}/pdf/view', [StoryPdfController::class, 'view'])
    ->name('stories.pdf.view');
Route::get('/stories/{story}/pdf/download', [StoryPdfController::class, 'download'])
    ->name('stories.pdf.download');

// Imported PDFs are private and accessible only by their owner.
Route::middleware('auth')->prefix('pdf-library')->name('pdf-library.')->group(function () {
    Route::get('/', [PdfLibraryController::class, 'index'])->name('index');
    Route::post('/', [PdfLibraryController::class, 'store'])->name('store');
    Route::get('/{pdfDocument}', [PdfLibraryController::class, 'show'])
        ->whereNumber('pdfDocument')->name('show');
    Route::get('/{pdfDocument}/preview', [PdfLibraryController::class, 'preview'])
        ->whereNumber('pdfDocument')->name('preview');
    Route::get('/{pdfDocument}/download', [PdfLibraryController::class, 'download'])
        ->whereNumber('pdfDocument')->name('download');
    Route::delete('/{pdfDocument}', [PdfLibraryController::class, 'destroy'])
        ->whereNumber('pdfDocument')->name('destroy');
});
