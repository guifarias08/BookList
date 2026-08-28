<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::patch('/books/{book}/rating', [BookController::class, 'rating'])
    ->name('books.rating');

Route::resource('books', BookController::class)
    ->except(['show']);
