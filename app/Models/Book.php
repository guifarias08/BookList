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
    ];
    
    protected $casts = [
        'publication_year' => 'integer',
        'rating' => 'integer',
    ];
}