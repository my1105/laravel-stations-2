<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController as PublicMovieController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\ReservationController;

Route::get('/movies', [PublicMovieController::class, 'index'])->name('movies.index');

Route::prefix('admin')->group(function () {
    Route::get('movies', [AdminMovieController::class, 'index'])->name('admin.movies.index');
    Route::get('movies/create', [AdminMovieController::class, 'create'])->name('admin.movies.create');
    Route::post('movies/store', [AdminMovieController::class, 'store'])->name('admin.movies.store');
    Route::get('movies/{id}', [AdminMovieController::class, 'show'])->name('admin.movies.show');
    Route::get('movies/{id}/edit', [AdminMovieController::class, 'edit'])->name('admin.movies.edit');
    Route::patch('movies/{id}/update', [AdminMovieController::class, 'update'])->name('admin.movies.update');
    Route::delete('movies/{id}/destroy', [AdminMovieController::class, 'destroy'])->name('admin.movies.destroy');
    Route::get('schedules', [ScheduleController::class, 'index'])->name('admin.schedules.index');
    Route::get('schedules/{id}', [ScheduleController::class, 'show'])->name('admin.schedules.show');
    Route::get('schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('admin.schedules.edit');
    Route::patch('schedules/{id}/update', [ScheduleController::class, 'update'])->name('admin.schedules.update');
    Route::delete('schedules/{id}/destroy', [ScheduleController::class, 'destroy'])->name('admin.schedules.destroy');
    Route::get('movies/{id}/schedules/create', [ScheduleController::class, 'create'])->name('admin.schedules.create');
    Route::post('movies/{id}/schedules/store', [ScheduleController::class, 'store'])->name('admin.schedules.store');
});

Route::get('/movies/{id}', [PublicMovieController::class, 'show'])->name('movies.show');

Route::get('/movies/{movie}/schedules/{schedule}/sheets', [SheetController::class, 'index'])->name('sheets.index');

Route::get('/movies/{movie_id}/schedules/{schedule_id}/reservations/create', [ReservationController::class, 'create'])
    ->name('reservation.create');
Route::post('/reservations/store', [ReservationController::class, 'store'])
    ->name('reservation.store');

Route::get('/sheets', [SheetController::class, 'indexSimple'])->name('sheets.simple');
