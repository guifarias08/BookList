@extends('layouts.app')

@section('title', 'Editar livro | BookList')

@section('content')

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


<section class="form-card">

    <div class="form-heading">

        <div class="form-heading-icon">
            ✏️
        </div>

        <div>

            <h2>Editando: {{ $book->title }}</h2>

            <p>
                Altere as informações abaixo e salve as alterações.
            </p>

        </div>

    </div>


    <form
        action="{{ route('books.update', $book) }}"
        method="POST"
        id="bookForm"
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
                    autofocus
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
                    <div class="form-group">

            <label for="status">
                Status de leitura <span>*</span>
            </label>

            <select id="status" name="status" required>

                <option value="want_to_read"
                    @selected(old('status', $book->status) === 'want_to_read')}>
                    📕 Quero ler
                </option>

                <option value="reading"
                    @selected(old('status', $book->status) === 'reading')}>
                    📖 Lendo
                </option>

                <option value="read"
                    @selected(old('status', $book->status) === 'read')}>
                    ✅ Lido
                </option>

                <option value="paused"
                    @selected(old('status', $book->status) === 'paused')}>
                    ⏸️ Pausado
                </option>

                <option value="abandoned"
                    @selected(old('status', $book->status) === 'abandoned')}>
                    ❌ Abandonei
                </option>

            </select>

            @error('status')
                <small>{{ $message }}</small>
            @enderror

                    </div>
                    <div class="form-group">

                <label>
                    Avaliação
                </label>

                <div class="rating-input" id="ratingInput">

                    @for($i = 1; $i <= 5; $i++)

                        <button
                            type="button"
                            class="star"
                            data-rating="{{ $i }}"
                        >
                            ★
                        </button>

                    @endfor

                </div>

                <input
                    type="hidden"
                    name="rating"
                    id="rating"
                    value="{{ old('rating', $book->rating) }}"
                >

                <span id="ratingText" class="rating-text">
                    @if($book->rating)
                        {{ $book->rating }}/5 estrelas
                    @else
                        Selecione uma nota
                    @endif
                </span>

                @error('rating')
                    <small>{{ $message }}</small>
                @enderror

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
       <script src="{{ asset('js/app.js') }}"></script>
@endsection