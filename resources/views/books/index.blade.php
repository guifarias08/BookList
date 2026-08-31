@extends('layouts.app')

@section('title', 'BookList | Minha Biblioteca')

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
            Organize suas leituras e acompanhe seu progresso.
        </p>

    </div>

    <a
        href="{{ route('books.create') }}"
        class="btn-primary"
    >
        ＋ Adicionar livro
    </a>

</div>


<section class="stats">

    <div class="stat-card">

        <div class="stat-icon blue">
            📚
        </div>

        <div>
            <span class="stat-label">
                Total de livros
            </span>

            <strong class="stat-value">
                {{ $totalBooks }}
            </strong>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon reading">
            📖
        </div>

        <div>
            <span class="stat-label">
                Lendo agora
            </span>

            <strong class="stat-value">
                {{ $totalReading }}
            </strong>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon green">
            ✅
        </div>

        <div>
            <span class="stat-label">
                Concluídos
            </span>

            <strong class="stat-value">
                {{ $totalRead }}
            </strong>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon purple">
            ⭐
        </div>

        <div>
            <span class="stat-label">
                Avaliação média
            </span>

            <strong class="stat-value">
                {{ number_format($averageRating ?? 0, 1, ',', '.') }}
            </strong>
        </div>

    </div>

</section>


<section class="reading-summary">

    <a
        href="{{ route('books.index', ['status' => 'want_to_read']) }}"
        class="summary-item"
    >
        📕
        <strong>{{ $totalWantToRead }}</strong>
        <span>Quero ler</span>
    </a>


    <a
        href="{{ route('books.index', ['status' => 'paused']) }}"
        class="summary-item"
    >
        ⏸️
        <strong>{{ $totalPaused }}</strong>
        <span>Pausados</span>
    </a>


    <a
        href="{{ route('books.index', ['status' => 'abandoned']) }}"
        class="summary-item"
    >
        ❌
        <strong>{{ $totalAbandoned }}</strong>
        <span>Abandonados</span>
    </a>


    <a
        href="{{ route('books.index', ['favorites' => 1]) }}"
        class="summary-item"
    >
        ❤️
        <strong>{{ $totalFavorites }}</strong>
        <span>Favoritos</span>
    </a>

</section>


<section class="filters">

    <form
        action="{{ route('books.index') }}"
        method="GET"
        class="filter-form"
    >

        <div class="search-wrapper">

            <span class="search-icon">
                🔍
            </span>

            <input
                type="search"
                name="search"
                class="search-input"
                value="{{ request('search') }}"
                placeholder="Buscar por título ou autor..."
            >

        </div>


        <select
            name="genre"
            class="select"
        >

            <option value="">
                Todos os gêneros
            </option>

            @foreach($genres as $genre)

                <option
                    value="{{ $genre }}"
                    @selected(request('genre') === $genre)
                >
                    {{ $genre }}
                </option>

            @endforeach

        </select>


        <select
            name="status"
            class="select"
        >

            <option value="">
                Todos os status
            </option>

            <option
                value="want_to_read"
                @selected(request('status') === 'want_to_read')
            >
                📕 Quero ler
            </option>

            <option
                value="reading"
                @selected(request('status') === 'reading')
            >
                📖 Lendo
            </option>

            <option
                value="read"
                @selected(request('status') === 'read')
            >
                ✅ Lido
            </option>

            <option
                value="paused"
                @selected(request('status') === 'paused')
            >
                ⏸️ Pausado
            </option>

            <option
                value="abandoned"
                @selected(request('status') === 'abandoned')
            >
                ❌ Abandonei
            </option>

        </select>


        <select
            name="sort"
            class="select"
        >

            <option value="">
                Ordenar por
            </option>

            <option
                value="recent"
                @selected(request('sort') === 'recent')
            >
                Mais recentes
            </option>

            <option
                value="rating"
                @selected(request('sort') === 'rating')
            >
                Melhor avaliação
            </option>

            <option
                value="newest"
                @selected(request('sort') === 'newest')
            >
                Ano mais recente
            </option>

            <option
                value="oldest"
                @selected(request('sort') === 'oldest')
            >
                Ano mais antigo
            </option>

            <option
                value="title_desc"
                @selected(request('sort') === 'title_desc')
            >
                Título Z → A
            </option>

        </select>


        @if(request('favorites'))
            <input
                type="hidden"
                name="favorites"
                value="1"
            >
        @endif


        <button
            type="submit"
            class="btn-search"
        >
            Buscar
        </button>


        <a
            href="{{ route('books.index') }}"
            class="btn-clear"
        >
            Limpar
        </a>

    </form>

</section>


<div class="library-toolbar">

    <div>

        <h2>
            Livros
        </h2>

        <span>
            {{ $books->total() }}
            {{ $books->total() === 1 ? 'resultado' : 'resultados' }}
        </span>

    </div>


    <div class="view-buttons">

        <button
            type="button"
            id="gridViewButton"
            class="view-button"
            title="Visualização em grade"
        >
            ▦
        </button>

        <button
            type="button"
            id="listViewButton"
            class="view-button"
            title="Visualização em lista"
        >
            ☰
        </button>

    </div>

</div>


@if($books->count())


    <section
        id="booksContainer"
        class="books-grid"
    >

        @foreach($books as $book)

            <article class="book-card">


                <div class="book-card-cover">

                    @if($book->cover)

                        <img
                            src="{{ asset('storage/' . $book->cover) }}"
                            alt="Capa de {{ $book->title }}"
                        >

                    @else

                        <div class="book-cover-placeholder">
                            📚
                        </div>

                    @endif


                    <form
                        action="{{ route('books.favorite', $book) }}"
                        method="POST"
                        class="favorite-form"
                    >

                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="favorite-button"
                            title="Favoritar"
                        >
                            {{ $book->favorite ? '❤️' : '🤍' }}
                        </button>

                    </form>

                </div>


                <div class="book-card-content">


                    <div class="book-card-top">

                        @if($book->genre)

                            <span class="badge">
                                {{ $book->genre }}
                            </span>

                        @endif


                        <span class="status-badge {{ $book->status_class }}">

                            {{ $book->status_icon }}

                            {{ $book->status_label }}

                        </span>

                    </div>


                    <h3>
                        {{ $book->title }}
                    </h3>


                    <p class="book-author">
                        {{ $book->author }}
                    </p>


                    @if($book->publication_year)

                        <p class="book-meta">
                            📅 {{ $book->publication_year }}
                        </p>

                    @endif


                    <form
                        action="{{ route('books.rating', $book) }}"
                        method="POST"
                        class="rating-form"
                    >

                        @csrf
                        @method('PATCH')


                        <div class="table-rating">

                            @for($i = 1; $i <= 5; $i++)

                                <button
                                    type="submit"
                                    name="rating"
                                    value="{{ $i }}"
                                    class="star-button {{ ($book->rating ?? 0) >= $i ? 'star-filled' : 'star-empty' }}"
                                >
                                    ★
                                </button>

                            @endfor


                            @if($book->rating)

                                <span class="rating-number">
                                    {{ $book->rating }}/5
                                </span>

                            @endif

                        </div>

                    </form>


                    @if($book->pages)

                        <div class="book-progress">

                            <div class="progress-info">

                                <span>
                                    Progresso
                                </span>

                                <strong>
                                    {{ $book->progress }}%
                                </strong>

                            </div>


                            <div class="progress-track">

                                <div
                                    class="progress-value"
                                    style="width: {{ $book->progress }}%"
                                ></div>

                            </div>


                            <small>

                                {{ $book->current_page ?? 0 }}

                                /

                                {{ $book->pages }}

                                páginas

                            </small>

                        </div>

                    @endif


                    <div class="book-card-actions">

                        <a
                            href="{{ route('books.show', $book) }}"
                            class="action-button view"
                        >
                            👁 Ver
                        </a>


                        <a
                            href="{{ route('books.edit', $book) }}"
                            class="action-button edit"
                        >
                            ✏️ Editar
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
                            >
                                🗑 Excluir
                            </button>

                        </form>

                    </div>

                </div>

            </article>

        @endforeach

    </section>


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

                Página
                {{ $books->currentPage() }}

                de

                {{ $books->lastPage() }}

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


    <section class="empty">

        <div class="empty-icon">
            📚
        </div>

        <h3>
            Nenhum livro encontrado
        </h3>

        <p>
            Tente alterar os filtros ou adicione um novo livro.
        </p>

        <a
            href="{{ route('books.create') }}"
            class="btn-primary"
        >
            ＋ Adicionar livro
        </a>

    </section>

@endif


@endsection