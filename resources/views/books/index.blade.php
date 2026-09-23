@extends('layouts.app')

@section('title', 'Acervo | BookList')

@section('content')
<section class="page-heading">
    <div>
        <span class="eyebrow">BIBLIOTECA ESCOLAR</span>
        <h1>Acervo de livros</h1>
        <p>Consulte, organize e acompanhe os livros cadastrados na biblioteca.</p>
    </div>

    <a href="{{ route('books.create') }}" class="btn btn-primary">Cadastrar livro</a>
</section>

<section class="stats-grid" aria-label="Resumo do acervo">
    <article class="stat-card">
        <div class="stat-icon" aria-hidden="true">B</div>
        <div><span>Total de livros</span><strong>{{ $totalBooks ?? $books->total() }}</strong></div>
    </article>

    <article class="stat-card">
        <div class="stat-icon want" aria-hidden="true">☆</div>
        <div><span>Quero ler</span><strong>{{ $totalWantToRead ?? 0 }}</strong></div>
    </article>

    <article class="stat-card">
        <div class="stat-icon reading" aria-hidden="true">▶</div>
        <div><span>Lendo</span><strong>{{ $totalReading ?? 0 }}</strong></div>
    </article>

    <article class="stat-card">
        <div class="stat-icon completed" aria-hidden="true">✓</div>
        <div><span>Concluídos</span><strong>{{ $totalRead ?? 0 }}</strong></div>
    </article>
</section>

<section class="panel filter-panel">
    <div class="panel-header-simple">
        <div>
            <h2>Filtros do acervo</h2>
            <p>Encontre rapidamente um livro cadastrado.</p>
        </div>
    </div>

    <form action="{{ route('books.index') }}" method="GET" class="filter-grid">
        <div class="field search-field">
            <label for="search">Buscar livro</label>
            <input type="search" id="search" name="search"
                   value="{{ request('search') }}"
                   placeholder="Título, autor ou ISBN...">
        </div>

        <div class="field">
            <label for="genre">Gênero</label>
            <select name="genre" id="genre">
                <option value="">Todos</option>
                @foreach($genres ?? [] as $genre)
                    <option value="{{ $genre }}" @selected(request('genre') === $genre)>{{ $genre }}</option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="">Todos</option>
                <option value="want_to_read" @selected(request('status') === 'want_to_read')>Quero ler</option>
                <option value="reading" @selected(request('status') === 'reading')>Lendo</option>
                <option value="read" @selected(request('status') === 'read')>Concluído</option>
                <option value="paused" @selected(request('status') === 'paused')>Pausado</option>
                <option value="abandoned" @selected(request('status') === 'abandoned')>Abandonado</option>
            </select>
        </div>

        <div class="field">
            <label for="sort">Ordenar por</label>
            <select name="sort" id="sort">
                <option value="">Título A–Z</option>
                <option value="title_desc" @selected(request('sort') === 'title_desc')>Título Z–A</option>
                <option value="recent" @selected(request('sort') === 'recent')>Cadastro recente</option>
                <option value="newest" @selected(request('sort') === 'newest')>Ano mais recente</option>
                <option value="oldest" @selected(request('sort') === 'oldest')>Ano mais antigo</option>
                <option value="rating" @selected(request('sort') === 'rating')>Melhor avaliação</option>
            </select>
        </div>

        <label class="favorite-filter">
            <input type="checkbox" name="favorites" value="1" @checked(request()->boolean('favorites'))>
            <span>Somente favoritos</span>
        </label>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>
</section>

<section class="panel library-panel">
    <div class="library-header">
        <div>
            <h2>Livros cadastrados</h2>
            <p>{{ $books->total() }} livro(s) encontrado(s)</p>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="books-table">
            <thead>
                <tr>
                    <th>Livro</th>
                    <th>Autor</th>
                    <th>Gênero</th>
                    <th>Ano</th>
                    <th>Progresso</th>
                    <th>Status</th>
                    <th>Nota</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    @php
                        $progress = ($book->pages ?? 0) > 0
                            ? min(100, round((($book->current_page ?? 0) / $book->pages) * 100))
                            : 0;
                    @endphp

                    <tr>
                        <td data-label="Livro">
                            <div class="book-cell">
                                <div class="book-cover-small">
                                    @if($book->cover)
                                        <img src="{{ asset('storage/' . $book->cover) }}" alt="Capa de {{ $book->title }}" loading="lazy">
                                    @else
                                        <span aria-hidden="true">{{ strtoupper(substr($book->title, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <strong>{{ $book->title }}</strong>
                                    <small>{{ $book->isbn ?: 'Sem ISBN' }}</small>
                                </div>
                            </div>
                        </td>

                        <td data-label="Autor">{{ $book->author }}</td>
                        <td data-label="Gênero">{{ $book->genre ?: '—' }}</td>
                        <td data-label="Ano">{{ $book->publication_year ?: '—' }}</td>

                        <td data-label="Progresso">
                            @if(($book->pages ?? 0) > 0)
                                <div class="progress-cell" aria-label="Progresso de leitura: {{ $progress }}%">
                                    <div class="progress-header">
                                        <span>{{ $book->current_page ?? 0 }} / {{ $book->pages }}</span>
                                        <span>{{ $progress }}%</span>
                                    </div>
                                    <div class="progress-track" aria-hidden="true">
                                        <span style="width: {{ $progress }}%"></span>
                                    </div>
                                </div>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        <td data-label="Status"><x-status-badge :status="$book->status" /></td>

                        <td data-label="Nota">
                            @if($book->rating)
                                <span class="rating-badge">{{ $book->rating }}/5</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        <td data-label="Ações">
                            <div class="table-actions">
                                <form action="{{ route('books.favorite', $book) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="action-button favorite-button {{ $book->favorite ? 'is-favorite' : '' }}"
                                            aria-label="{{ $book->favorite ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}">
                                        {{ $book->favorite ? '★' : '☆' }}
                                    </button>
                                </form>
                                <a href="{{ route('books.show', $book) }}" class="action-button">Ver</a>
                                <a href="{{ route('books.edit', $book) }}" class="action-button">Editar</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="8" class="empty-table-cell">
                            <div class="empty-state">
                                <div class="empty-icon" aria-hidden="true">B</div>
                                <h3>Nenhum livro encontrado</h3>
                                <p>Cadastre um novo livro ou altere os filtros.</p>
                                <a href="{{ route('books.create') }}" class="btn btn-primary">Cadastrar livro</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($books->hasPages())
        <nav class="pagination-area" aria-label="Paginação do acervo">
            @if($books->onFirstPage())
                <span class="pagination-link disabled" aria-disabled="true">Anterior</span>
            @else
                <a class="pagination-link" href="{{ $books->previousPageUrl() }}" rel="prev">Anterior</a>
            @endif

            <span class="pagination-info">Página {{ $books->currentPage() }} de {{ $books->lastPage() }}</span>

            @if($books->hasMorePages())
                <a class="pagination-link" href="{{ $books->nextPageUrl() }}" rel="next">Próxima</a>
            @else
                <span class="pagination-link disabled" aria-disabled="true">Próxima</span>
            @endif
        </nav>
    @endif
</section>
@endsection