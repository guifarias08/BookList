<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'genre',
        'publication_year',
        'description',
        'isbn',
        'cover',
        'status',
        'rating',
        'pages',
        'current_page',
        'favorite',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'rating' => 'integer',
        'pages' => 'integer',
        'current_page' => 'integer',
        'favorite' => 'boolean',
    ];
}