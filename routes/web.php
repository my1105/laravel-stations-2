<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController as PublicMovieController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// 認証が不要な公開ページ（ゲスト用）
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/users/create', [RegisteredUserController::class, 'create'])->name('users.create');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// 認証が必要なページ
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () => 'ダッシュボード')->name('dashboard');

    // 映画関連
    Route::get('/movies', [PublicMovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/{movie}', [PublicMovieController::class, 'show'])->name('movies.show');

    // シート関連
    Route::get('/sheets', [SheetController::class, 'index']);
    Route::get('/sheets/simple', [SheetController::class, 'indexSimple'])->name('sheets.simple');
    Route::get('/movies/{movie}/schedules/{schedule}/sheets', [SheetController::class, 'index'])->name('public.sheets.index');

    // 予約関連
    Route::get('/movies/{movie}/schedules/{schedule}/reservations/create', [ReservationController::class, 'create'])->name('reservation.create');
    Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservation.store');

    // ログアウト
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// 管理者ページ
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

    Route::get('reservations', [AdminReservationController::class, 'index'])->name('admin.reservations.index');
    Route::get('reservations/create', [AdminReservationController::class, 'create'])->name('admin.reservations.create');
    Route::post('reservations', [AdminReservationController::class, 'store'])->name('admin.reservations.store');
    Route::get('reservations/{id}/edit', [AdminReservationController::class, 'edit'])->name('admin.reservations.edit');
    Route::match(['put', 'patch'], 'reservations/{id}', [AdminReservationController::class, 'update'])->name('admin.reservations.update');
    Route::delete('reservations/{id}', [AdminReservationController::class, 'destroy'])->name('admin.reservations.destroy');
});

require __DIR__.'/auth.php';
