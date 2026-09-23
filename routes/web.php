<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('books.index');
    });

    Route::patch(
        '/books/{book}/rating',
        [BookController::class, 'rating']
    )->name('books.rating');

    Route::patch(
        '/books/{book}/favorite',
        [BookController::class, 'favorite']
    )->name('books.favorite');

    Route::resource('books', BookController::class);
});
