<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('books', 'description')) {
            Schema::table('books', function (Blueprint $table) {
                $table->text('description')->nullable();
            });
        }

        if (!Schema::hasColumn('books', 'isbn')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('isbn', 30)->nullable();
            });
        }

        if (!Schema::hasColumn('books', 'cover')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('cover')->nullable();
            });
        }

        if (!Schema::hasColumn('books', 'pages')) {
            Schema::table('books', function (Blueprint $table) {
                $table->unsignedInteger('pages')->nullable();
            });
        }

        if (!Schema::hasColumn('books', 'current_page')) {
            Schema::table('books', function (Blueprint $table) {
                $table->unsignedInteger('current_page')->default(0);
            });
        }

        if (!Schema::hasColumn('books', 'favorite')) {
            Schema::table('books', function (Blueprint $table) {
                $table->boolean('favorite')->default(false);
            });
        }
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'cover',
                'pages',
                'current_page',
                'favorite',
            ]);
        });
    }
};