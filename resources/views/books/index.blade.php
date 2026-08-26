<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BookList - Minha Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

<header class="navbar">

    <div class="navbar-container">

        <a href="{{ route('books.index') }}" class="logo">
            <span class="logo-icon">📚</span>
            <span>BookList</span>
        </a>

        <nav class="nav-links">

            <a
                href="{{ route('books.index') }}"
                class="nav-link active"
            >
                Início
            </a>

            <a
                href="{{ route('books.index') }}"
                class="nav-link"
            >
                Livros
            </a>

        </nav>

    </div>

</header>


<main class="container">

    {{-- Mensagem de sucesso --}}
    @if(session('success'))

        <div class="success-message">
            <span>✓</span>
            {{ session('success') }}
        </div>

    @endif


    {{-- Erros --}}
    @if($errors->any())

        <div class="error-message">

            <strong>Verifique os dados:</strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Cabeçalho --}}

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


    {{-- Estatísticas --}}

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


    {{-- Busca --}}

    <section class="filters">

        <form
            method="GET"
            action="{{ route('books.index') }}"
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


            <select name="genre" class="select">

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


            <button type="submit" class="btn-search">
                Buscar
            </button>


            @if(request('search') || request('genre'))

                <a
                    href="{{ route('books.index') }}"
                    class="btn-clear"
                >
                    Limpar
                </a>

            @endif

        </form>

    </section>


    {{-- Tabela --}}

    <section class="table-card">

        <div class="table-header">

            <div>

                <h2 class="table-title">
                    Livros
                </h2>

                <span class="table-count">
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
                                <th>Ações</th>
                            </tr>
                        </thead>

                    <tbody>

                        @foreach($books as $book)

                            <tr>

                                <td>

                                    <div class="book-info">

                                        <div class="book-icon">
                                            📖
                                        </div>

                                        <div>

                                            <div class="book-title">
                                                {{ $book->title }}
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
                                <div class="book-actions">

                                    <a
                                        href="{{ route('books.edit', $book) }}"
                                        class="btn-edit"
                                    >
                                        ✏️ Editar
                                    </a>

                                    <form
                                        action="{{ route('books.destroy', $book) }}"
                                        method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este livro?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn-delete"
                                        >
                                            🗑️ Excluir
                                        </button>

                                    </form>

                                </div>
                            </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Paginação --}}

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

</main>

</body>
</html>