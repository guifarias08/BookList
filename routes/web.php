<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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