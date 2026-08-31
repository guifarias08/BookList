<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {

            if (!Schema::hasColumn('books', 'title')) {
                $table->string('title')->nullable();
            }

            if (!Schema::hasColumn('books', 'author')) {
                $table->string('author')->nullable();
            }

            if (!Schema::hasColumn('books', 'genre')) {
                $table->string('genre')->nullable();
            }

            if (!Schema::hasColumn('books', 'year')) {
                $table->unsignedSmallInteger('year')->nullable();
            }

            if (!Schema::hasColumn('books', 'description')) {
                $table->text('description')->nullable();
            }

            if (!Schema::hasColumn('books', 'isbn')) {
                $table->string('isbn', 20)->nullable();
            }

            if (!Schema::hasColumn('books', 'cover')) {
                $table->string('cover')->nullable();
            }

            if (!Schema::hasColumn('books', 'status')) {
                $table->string('status')
                    ->default('Quero ler');
            }
        });
    }

    public function down(): void
    {
        $columns = [];

        foreach ([
            'title',
            'author',
            'genre',
            'year',
            'description',
            'publication_year',
            'isbn',
            'status',
        ] as $column) {

            if (Schema::hasColumn('books', $column)) {
                $columns[] = $column;
            }
        }

        if (!empty($columns)) {
            Schema::table('books', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};