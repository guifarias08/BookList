<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Busca por título ou autor
        if ($request->filled('search')) {

            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%");

            });
        }

        // Filtro por gênero
        if ($request->filled('genre')) {

            $query->where('genre', $request->input('genre'));

        }

        // Filtro por status
        if ($request->filled('status')) {

            $query->where('status', $request->input('status'));

        }

        $books = $query
            ->orderBy('title')
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

        $genres = Book::whereNotNull('genre')
            ->where('genre', '!=', '')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

            $totalWantToRead = Book::where('status', 'want_to_read')->count();

            $totalReading = Book::where('status', 'reading')->count();

            $totalRead = Book::where('status', 'read')->count();

            $totalPaused = Book::where('status', 'paused')->count();

            $totalAbandoned = Book::where('status', 'abandoned')->count();

        return view('books.index', compact(
            'books',
            'totalBooks',
            'totalAuthors',
            'totalGenres',
            'genres',
            'totalWantToRead',
            'totalReading',
            'totalRead',
            'totalPaused',
            'totalAbandoned',
            
));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {       //dd($request->all());
        $validated = $request->validate([
               'title' => ['required', 'string', 'max:255'],
                'author' => ['required', 'string', 'max:255'],
                'genre' => ['nullable', 'string', 'max:255'],
                'publication_year' => ['nullable', 'integer', 'min:1000', 'max:' . date('Y')],
                'status' => [
                    'required',
                    'in:want_to_read,reading,read,paused,abandoned'
            ],
                    'rating' => [
                'nullable',
                'integer',
                'min:1',
                'max:5'
                            ],             
        ], [
            'title.required' => 'Informe o título do livro.',
            'author.required' => 'Informe o autor do livro.',
            'publication_year.min' => 'Informe um ano válido.',
            'publication_year.max' => 'O ano não pode ser maior que ' . date('Y') . '.',
         
        ]);

        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro adicionado com sucesso!');
    }

    /*
    |--------------------------------------------------------------------------
    | EDITAR
    |--------------------------------------------------------------------------
    */

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /*
    |--------------------------------------------------------------------------
    | ATUALIZAR
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
              'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'genre' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'min:1000', 'max:' . date('Y')],
            'status' => [
                'required',
            'in:want_to_read,reading,read,paused,abandoned'
            ],
        ], [
            'title.required' => 'Informe o título do livro.',
            'author.required' => 'Informe o autor do livro.',
            'publication_year.min' => 'Informe um ano válido.',
            'publication_year.max' => 'O ano não pode ser maior que ' . date('Y') . '.',
        ]);

        $book->update($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro atualizado com sucesso!');
    }
    
            public function rating(Request $request, Book $book)
                {
                    $validated = $request->validate([
                        'rating' => ['required', 'integer', 'between:1,5'],
                    ]);

                    $book->update([
                        'rating' => $validated['rating'],
                    ]);

                    return redirect()
                        ->back()
                        ->with('success', 'Avaliação atualizada com sucesso!');
                }

    /*
    |--------------------------------------------------------------------------
    | EXCLUIR
    |--------------------------------------------------------------------------
    */

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro excluído com sucesso!');
    }
}