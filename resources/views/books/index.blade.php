@extends('layouts.app')

@section('title', 'BookList - Minha Biblioteca')

@section('content')

<div class="page-header">

    <div>

        <span class="eyebrow">
            MINHA BIBLIOTECA
        </span>

        <h1 class="page-title">
            Coleção de livros
        </h1>

        <p class="page-description">
            Gerencie sua biblioteca de forma simples e organizada.
        </p>

    </div>

    <a
        href="{{ route('books.create') }}"
        class="btn-primary"
    >
        <span>＋</span>
        Adicionar livro
    </a>

</div>


<section class="stats">

    <div class="stat-card">

        <div class="stat-icon blue">
            📚
        </div>

        <div>
            <div class="stat-label">
                Total de livros
            </div>

            <div class="stat-value">
                {{ $totalBooks }}
            </div>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon green">
            ✍️
        </div>

        <div>
            <div class="stat-label">
                Autores
            </div>

            <div class="stat-value">
                {{ $totalAuthors }}
            </div>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon purple">
            🏷️
        </div>

        <div>
            <div class="stat-label">
                Gêneros
            </div>

            <div class="stat-value">
                {{ $totalGenres }}
            </div>
        </div>

    </div>

</section>


<section class="filters">

    <div class="filter-form">

        <div class="search-wrapper">

            <span class="search-icon">
                🔍
            </span>

            <input
                type="search"
                id="bookSearch"
                class="search-input"
                value="{{ request('search') }}"
                placeholder="Buscar por título ou autor..."
                autocomplete="off"
            >

        </div>


        <select
            id="genreFilter"
            class="select"
        >

            <option value="">
                Todos os gêneros
            </option>

            @foreach($genres as $genre)

                <option
                    value="{{ strtolower($genre) }}"
                    @selected(request('genre') === $genre)
                >
                    {{ $genre }}
                </option>

            @endforeach

        </select>


        <button
            type="button"
            class="btn-search"
            id="searchButton"
        >
            Buscar
        </button>


        <a
            href="{{ route('books.index') }}"
            class="btn-clear"
            id="clearFilters"
        >
            Limpar
        </a>

    </div>

</section>


<section class="table-card">

    <div class="table-header">

        <div>

            <h2 class="table-title">
                Livros
            </h2>

            <span
                class="table-count"
                id="resultCount"
            >
                {{ $books->total() }}
                {{ $books->total() === 1 ? 'resultado' : 'resultados' }}
            </span>

        </div>

    </div>


    @if($books->count())

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>Livro</th>
                        <th>Autor</th>
                        <th>Gênero</th>
                        <th>Publicação</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>

                </thead>

                <tbody id="booksTable">

                    @foreach($books as $book)

                        <tr
                            class="book-row"
                            data-title="{{ strtolower($book->title) }}"
                            data-author="{{ strtolower($book->author) }}"
                            data-genre="{{ strtolower($book->genre ?? '') }}"
                        >

                            <td>

                                <div class="book-info">

                                    <div class="book-icon">
                                        📖
                                    </div>

                                    <div>

                                        <div class="book-title">
                                            {{ $book->title }}
                                        </div>

                                        <div class="book-subtitle">
                                            Livro
                                        </div>

                                    </div>

                                </div>

                            </td>


                            <td class="author">
                                {{ $book->author }}
                            </td>


                            <td>

                                @if($book->genre)

                                    <span class="badge">
                                        {{ $book->genre }}
                                    </span>

                                @else

                                    <span class="muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            <td class="year">
                                {{ $book->publication_year ?? '—' }}
                            </td>

                                                        <td>
                            @php
                                $statuses = [
                                    'want_to_read' => [
                                        'label' => 'Quero ler',
                                        'class' => 'status-want',
                                        'icon' => '📕',
                                    ],
                                    'reading' => [
                                        'label' => 'Lendo',
                                        'class' => 'status-reading',
                                        'icon' => '📖',
                                    ],
                                    'read' => [
                                        'label' => 'Lido',
                                        'class' => 'status-read',
                                        'icon' => '✅',
                                    ],
                                    'paused' => [
                                        'label' => 'Pausado',
                                        'class' => 'status-paused',
                                        'icon' => '⏸️',
                                    ],
                                    'abandoned' => [
                                        'label' => 'Abandonei',
                                        'class' => 'status-abandoned',
                                        'icon' => '❌',
                                    ],
                                ];

                                $status = $statuses[$book->status] ?? $statuses['want_to_read'];
                            @endphp

                            <span class="status-badge {{ $status['class'] }}">
                                {{ $status['icon'] }}
                                {{ $status['label'] }}
                            </span>
                        </td>
                                            <select name="status" class="select">

                        <option value="">
                            Todos os status
                        </option>

                        <option value="want_to_read"
                            @selected(request('status') === 'want_to_read')}>
                            📕 Quero ler
                        </option>

                        <option value="reading"
                            @selected(request('status') === 'reading')}>
                            📖 Lendo
                        </option>

                        <option value="read"
                            @selected(request('status') === 'read')}>
                            ✅ Lido
                        </option>

                        <option value="paused"
                            @selected(request('status') === 'paused')}>
                            ⏸️ Pausado
                        </option>

                        <option value="abandoned"
                            @selected(request('status') === 'abandoned')}>
                            ❌ Abandonei
                        </option>

                    </select>
                            <td>

                                <div class="book-actions">

                                    <a
                                        href="{{ route('books.edit', $book) }}"
                                        class="action-button edit"
                                        title="Editar livro"
                                    >
                                        <span>✏️</span>
                                        <span>Editar</span>
                                    </a>


                                    <form
                                        action="{{ route('books.destroy', $book) }}"
                                        method="POST"
                                        class="delete-form"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-button delete"
                                            title="Excluir livro"
                                        >
                                            <span>🗑️</span>
                                            <span>Excluir</span>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        @if($books->hasPages())

            <div class="pagination">

                @if($books->onFirstPage())

                    <span class="page-disabled">
                        ← Anterior
                    </span>

                @else

                    <a
                        href="{{ $books->previousPageUrl() }}"
                        class="page-link"
                    >
                        ← Anterior
                    </a>

                @endif


                <span class="page-current">
                    Página {{ $books->currentPage() }}
                    de {{ $books->lastPage() }}
                </span>


                @if($books->hasMorePages())

                    <a
                        href="{{ $books->nextPageUrl() }}"
                        class="page-link"
                    >
                        Próxima →
                    </a>

                @else

                    <span class="page-disabled">
                        Próxima →
                    </span>

                @endif

            </div>

        @endif

    @else

        <div class="empty">

            <div class="empty-icon">
                📚
            </div>

            <h3 class="empty-title">
                Nenhum livro encontrado
            </h3>

            <p class="empty-text">

                @if(request('search') || request('genre'))

                    Tente alterar os filtros da busca.

                @else

                    Sua biblioteca ainda está vazia.

                @endif

            </p>

            <a
                href="{{ route('books.create') }}"
                class="btn-primary empty-button"
            >
                ＋ Adicionar primeiro livro
            </a>

        </div>

    @endif

</section>

@endsection