<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // BUSCA
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");

            });
        }

        // GÊNERO
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FAVORITOS
        if ($request->boolean('favorites')) {
            $query->where('favorite', true);
        }

        // ORDENAÇÃO
        switch ($request->input('sort')) {

            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;

            case 'newest':
                $query->orderBy('publication_year', 'desc');
                break;

            case 'oldest':
                $query->orderBy('publication_year', 'asc');
                break;

            case 'rating':
                $query
                    ->orderByDesc('rating')
                    ->orderBy('title');
                break;

            case 'recent':
                $query->latest();
                break;

            default:
                $query->orderBy('title');
                break;
        }

        $books = $query
            ->paginate(8)
            ->withQueryString();

        $totalBooks = Book::count();

        $totalAuthors = Book::whereNotNull('author')
            ->where('author', '!=', '')
            ->distinct()
            ->count('author');

        $totalGenres = Book::whereNotNull('genre')
            ->where('genre', '!=', '')
            ->distinct()
            ->count('genre');

        $totalWantToRead = Book::where('status', 'want_to_read')->count();

        $totalReading = Book::where('status', 'reading')->count();

        $totalRead = Book::where('status', 'read')->count();

        $totalPaused = Book::where('status', 'paused')->count();

        $totalAbandoned = Book::where('status', 'abandoned')->count();

        $totalFavorites = Book::where('favorite', true)->count();

        $averageRating = Book::whereNotNull('rating')
            ->avg('rating');

        $genres = Book::whereNotNull('genre')
            ->where('genre', '!=', '')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        return view('books.index', compact(
            'books',
            'totalBooks',
            'totalAuthors',
            'totalGenres',
            'totalWantToRead',
            'totalReading',
            'totalRead',
            'totalPaused',
            'totalAbandoned',
            'totalFavorites',
            'averageRating',
            'genres'
        ));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        $this->validateCurrentPage($request);

        if ($request->hasFile('cover')) {

            $validated['cover'] = $request
                ->file('cover')
                ->store('covers', 'public');
        }

        if ($validated['status'] === 'read' && !empty($validated['pages'])) {
            $validated['current_page'] = $validated['pages'];
        }

        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro adicionado com sucesso!');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        $this->validateCurrentPage($request);

        if ($request->hasFile('cover')) {

            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }

            $validated['cover'] = $request
                ->file('cover')
                ->store('covers', 'public');
        }

        if ($validated['status'] === 'read' && !empty($validated['pages'])) {
            $validated['current_page'] = $validated['pages'];
        }

        $book->update($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Book $book)
    {
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro excluído com sucesso!');
    }

    public function rating(Request $request, Book $book)
    {
        $validated = $request->validate([
            'rating' => [
                'required',
                'integer',
                'between:1,5',
            ],
        ]);

        $book->update([
            'rating' => $validated['rating'],
        ]);

        return back()
            ->with('success', 'Avaliação atualizada!');
    }

    public function favorite(Book $book)
    {
        $book->update([
            'favorite' => !$book->favorite,
        ]);

        return back();
    }

    private function validationRules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'author' => [
                'required',
                'string',
                'max:255',
            ],

            'genre' => [
                'nullable',
                'string',
                'max:255',
            ],

            'publication_year' => [
                'nullable',
                'integer',
                'min:1000',
                'max:' . date('Y'),
            ],

            'status' => [
                'required',
                'in:want_to_read,reading,read,paused,abandoned',
            ],

            'rating' => [
                'nullable',
                'integer',
                'between:1,5',
            ],

            'isbn' => [
                'nullable',
                'string',
                'max:30',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'pages' => [
                'nullable',
                'integer',
                'min:1',
                'max:100000',
            ],

            'current_page' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }

    private function validationMessages(): array
    {
        return [
            'title.required' =>
                'Informe o título do livro.',

            'author.required' =>
                'Informe o autor do livro.',

            'publication_year.min' =>
                'Informe um ano válido.',

            'publication_year.max' =>
                'O ano não pode ser maior que ' . date('Y') . '.',

            'cover.image' =>
                'A capa deve ser uma imagem.',

            'cover.max' =>
                'A imagem deve possuir no máximo 2 MB.',

            'pages.min' =>
                'O livro precisa possuir pelo menos uma página.',
        ];
    }

    private function validateCurrentPage(Request $request): void
    {
        if (
            $request->filled('pages')
            && $request->filled('current_page')
            && (int) $request->current_page > (int) $request->pages
        ) {

            abort(
                redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'current_page' =>
                            'A página atual não pode ser maior que o total de páginas.',
                    ])
            );
        }
    }
}