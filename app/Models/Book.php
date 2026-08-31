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

    public function getProgressAttribute(): int
    {
        if (!$this->pages || $this->pages <= 0) {
            return 0;
        }

        return min(
            100,
            (int) round(($this->current_page / $this->pages) * 100)
        );
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'want_to_read' => 'Quero ler',
            'reading' => 'Lendo',
            'read' => 'Lido',
            'paused' => 'Pausado',
            'abandoned' => 'Abandonei',
            default => 'Sem status',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'want_to_read' => '📕',
            'reading' => '📖',
            'read' => '✅',
            'paused' => '⏸️',
            'abandoned' => '❌',
            default => '📚',
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'want_to_read' => 'status-want',
            'reading' => 'status-reading',
            'read' => 'status-read',
            'paused' => 'status-paused',
            'abandoned' => 'status-abandoned',
            default => 'status-want',
        };
    }
}