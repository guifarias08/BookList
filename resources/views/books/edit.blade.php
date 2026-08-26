<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar livro | BookList</title>

       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
       <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

<header class="navbar">

    <div class="navbar-container">

        <a
            href="{{ route('books.index') }}"
            class="logo"
        >
            <span class="logo-icon">📚</span>
            BookList
        </a>

    </div>

</header>


<main class="container">

    <div class="page-header">

        <div>

            <span class="eyebrow">
                EDITAR LIVRO
            </span>

            <h1 class="page-title">
                Editar livro
            </h1>

            <p class="page-description">
                Atualize as informações do livro.
            </p>

        </div>

        <a
            href="{{ route('books.index') }}"
            class="btn-clear"
        >
            ← Voltar
        </a>

    </div>


    @if($errors->any())

        <div class="error-message">

            <strong>Corrija os seguintes erros:</strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <section class="form-card">

        <form
            action="{{ route('books.update', $book) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <div class="form-grid">

                <div class="form-group full">

                    <label for="title">
                        Título <span>*</span>
                    </label>

                    <input
                        id="title"
                        name="title"
                        type="text"
                        value="{{ old('title', $book->title) }}"
                        placeholder="Ex.: O Grande Gatsby"
                        required
                    >

                    @error('title')
                        <small>{{ $message }}</small>
                    @enderror

                </div>


                <div class="form-group">

                    <label for="author">
                        Autor <span>*</span>
                    </label>

                    <input
                        id="author"
                        name="author"
                        type="text"
                        value="{{ old('author', $book->author) }}"
                        placeholder="Ex.: F. Scott Fitzgerald"
                        required
                    >

                    @error('author')
                        <small>{{ $message }}</small>
                    @enderror

                </div>


                <div class="form-group">

                    <label for="genre">
                        Gênero
                    </label>

                    <input
                        id="genre"
                        name="genre"
                        type="text"
                        value="{{ old('genre', $book->genre) }}"
                        placeholder="Ex.: Ficção"
                    >

                    @error('genre')
                        <small>{{ $message }}</small>
                    @enderror

                </div>


                <div class="form-group">

                    <label for="publication_year">
                        Ano de publicação
                    </label>

                    <input
                        id="publication_year"
                        name="publication_year"
                        type="number"
                        value="{{ old('publication_year', $book->publication_year) }}"
                        placeholder="Ex.: 1925"
                        min="1000"
                        max="{{ date('Y') }}"
                    >

                    @error('publication_year')
                        <small>{{ $message }}</small>
                    @enderror

                </div>

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('books.index') }}"
                    class="btn-cancel"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn-primary"
                >
                    ✓ Salvar alterações
                </button>

            </div>

        </form>

    </section>

</main>

</body>
</html>