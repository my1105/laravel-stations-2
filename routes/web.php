<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController as PublicMovieController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;

Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);

Route::get('/movies', [PublicMovieController::class, 'index'])->name('movies.index');

Route::prefix('admin')->group(function () {
    Route::get('movies', [AdminMovieController::class, 'index'])->name('admin.movies.index');
    Route::get('movies/create', [AdminMovieController::class, 'create'])->name('admin.movies.create');
    Route::post('movies/store', [AdminMovieController::class, 'store'])->name('admin.movies.store');
    Route::get('movies/{id}', [AdminMovieController::class, 'show'])->name('admin.movies.show');
    Route::get('movies/{id}/edit', [AdminMovieController::class, 'edit'])->name('admin.movies.edit');
    Route::patch('movies/{id}/update', [AdminMovieController::class, 'update'])->name('admin.movies.update');


});
