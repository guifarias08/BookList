@extends('layouts.app')

@section('title', 'Acervo | BookList')

@section('content')


<section class="page-heading">

    <div>

        <span class="eyebrow">
            BIBLIOTECA ESCOLAR
        </span>

        <h1>
            Acervo de livros
        </h1>

        <p>
            Consulte, organize e acompanhe os livros cadastrados na biblioteca.
        </p>

    </div>


    <a
        href="{{ route('books.create') }}"
        class="btn btn-primary"
    >
        + Cadastrar livro
    </a>

</section>


<section class="stats-grid">

    <div class="stat-card">

        <div class="stat-icon">
            TL
        </div>

        <div>
            <span>Total de livros</span>

            <strong>
                {{ $totalBooks ?? $books->total() }}
            </strong>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon want">
            QL
        </div>

        <div>
            <span>Quero ler</span>

            <strong>
                {{ $wantToReadCount ?? 0 }}
            </strong>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon reading">
            LD
        </div>

        <div>
            <span>Lendo</span>

            <strong>
                {{ $readingCount ?? 0 }}
            </strong>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon completed">
            OK
        </div>

        <div>
            <span>Concluídos</span>

            <strong>
                {{ $readCount ?? 0 }}
            </strong>
        </div>

    </div>

</section>


<section class="panel filter-panel">

    <div class="panel-header-simple">

        <div>

            <h2>Filtros do acervo</h2>

            <p>
                Encontre rapidamente um livro cadastrado.
            </p>

        </div>

    </div>


    <form
        action="{{ route('books.index') }}"
        method="GET"
        class="filter-grid"
    >

        <div class="field search-field">

            <label for="search">
                Buscar livro
            </label>

            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Título, autor ou ISBN..."
            >

        </div>


        <div class="field">

            <label for="genre">
                Gênero
            </label>

            <select
                name="genre"
                id="genre"
            >

                <option value="">
                    Todos
                </option>

                @foreach($genres ?? [] as $genre)

                    <option
                        value="{{ $genre }}"
                        @selected(request('genre') === $genre)
                    >
                        {{ $genre }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="field">

            <label for="status">
                Status
            </label>

            <select
                name="status"
                id="status"
            >

                <option value="">
                    Todos
                </option>

                <option
                    value="want_to_read"
                    @selected(request('status') === 'want_to_read')
                >
                    Quero ler
                </option>

                <option
                    value="reading"
                    @selected(request('status') === 'reading')
                >
                    Lendo
                </option>

                <option
                    value="read"
                    @selected(request('status') === 'read')
                >
                    Concluído
                </option>

                <option
                    value="paused"
                    @selected(request('status') === 'paused')
                >
                    Pausado
                </option>

                <option
                    value="abandoned"
                    @selected(request('status') === 'abandoned')
                >
                    Abandonado
                </option>

            </select>

        </div>


        <div class="filter-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Filtrar
            </button>

            <a
                href="{{ route('books.index') }}"
                class="btn btn-secondary"
            >
                Limpar
            </a>

        </div>

    </form>

</section>


<section class="panel library-panel">

    <div class="library-header">

        <div>

            <h2>
                Livros cadastrados
            </h2>

            <p>
                {{ $books->total() }}
                livro(s) encontrado(s)
            </p>

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

                        $progress = 0;

                        if (
                            ($book->total_pages ?? 0) > 0
                            && ($book->current_page ?? 0) >= 0
                        ) {
                            $progress = min(
                                100,
                                round(
                                    (($book->current_page ?? 0)
                                    / $book->total_pages)
                                    * 100
                                )
                            );
                        }

                    @endphp


                    <tr>

                        <td>

                            <div class="book-cell">

                                <div class="book-cover-small">

                                    @if($book->cover)

                                        <img
                                            src="{{ asset('storage/' . $book->cover) }}"
                                            alt="{{ $book->title }}"
                                        >

                                    @else

                                        <span>
                                            {{ strtoupper(substr($book->title, 0, 1)) }}
                                        </span>

                                    @endif

                                </div>


                                <div>

                                    <strong>
                                        {{ $book->title }}
                                    </strong>

                                    <small>
                                        {{ $book->isbn ?: 'Sem ISBN' }}
                                    </small>

                                </div>

                            </div>

                        </td>


                        <td>
                            {{ $book->author }}
                        </td>


                        <td>
                            {{ $book->genre ?: '—' }}
                        </td>


                        <td>
                            {{ $book->publication_year ?: '—' }}
                        </td>


                        <td>

                            @if(($book->total_pages ?? 0) > 0)

                                <div class="progress-cell">

                                    <div class="progress-header">

                                        <span>
                                            {{ $book->current_page ?? 0 }}
                                            /
                                            {{ $book->total_pages }}
                                        </span>

                                        <span>
                                            {{ $progress }}%
                                        </span>

                                    </div>

                                    <div class="progress-track">

                                        <span
                                            style="width: {{ $progress }}%"
                                        ></span>

                                    </div>

                                </div>

                            @else

                                <span class="muted">
                                    —
                                </span>

                            @endif

                        </td>


                        <td>

                            <span class="status-badge status-{{ $book->status }}">

                                @switch($book->status)

                                    @case('want_to_read')
                                        Quero ler
                                        @break

                                    @case('reading')
                                        Lendo
                                        @break

                                    @case('read')
                                        Concluído
                                        @break

                                    @case('paused')
                                        Pausado
                                        @break

                                    @case('abandoned')
                                        Abandonado
                                        @break

                                    @default
                                        {{ $book->status }}

                                @endswitch

                            </span>

                        </td>


                        <td>

                            @if($book->rating)

                                <span class="rating-badge">
                                    {{ $book->rating }}/5
                                </span>

                            @else

                                <span class="muted">
                                    —
                                </span>

                            @endif

                        </td>


                        <td>

                            <div class="table-actions">

                                <a
                                    href="{{ route('books.show', $book) }}"
                                    class="action-button"
                                >
                                    Ver
                                </a>

                                <a
                                    href="{{ route('books.edit', $book) }}"
                                    class="action-button"
                                >
                                    Editar
                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    B
                                </div>

                                <h3>
                                    Nenhum livro encontrado
                                </h3>

                                <p>
                                    Cadastre um novo livro ou altere os filtros.
                                </p>

                                <a
                                    href="{{ route('books.create') }}"
                                    class="btn btn-primary"
                                >
                                    + Cadastrar livro
                                </a>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    @if($books->hasPages())

        <div class="pagination-area">
            {{ $books->links() }}
        </div>

    @endif

</section>

@endsection