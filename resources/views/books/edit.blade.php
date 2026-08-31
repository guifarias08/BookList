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
            Atualize as informações da sua leitura.
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

            <h2>
                {{ $book->title }}
            </h2>

            <p>
                Atualize os dados abaixo.
            </p>

        </div>

    </div>


    <form
        action="{{ route('books.update', $book) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')


        <div class="book-form-layout">


            <div class="cover-upload-area">

                <div class="cover-preview">

                    @if($book->cover)

                        <img
                            id="coverPreview"
                            class="cover-preview-image"
                            src="{{ asset('storage/' . $book->cover) }}"
                            alt="{{ $book->title }}"
                        >

                        <div
                            id="coverPlaceholder"
                            class="cover-placeholder hidden"
                        >
                            📚
                        </div>

                    @else

                        <img
                            id="coverPreview"
                            class="cover-preview-image hidden"
                            alt="Prévia"
                        >

                        <div
                            id="coverPlaceholder"
                            class="cover-placeholder"
                        >
                            📚

                            <span>
                                Sem capa
                            </span>
                        </div>

                    @endif

                </div>


                <label
                    for="cover"
                    class="cover-upload-button"
                >
                    📷 Alterar capa
                </label>

                <input
                    id="cover"
                    name="cover"
                    type="file"
                    accept="image/png,image/jpeg,image/webp"
                    class="hidden"
                >

            </div>


            <div class="form-grid">

                <div class="form-group full">

                    <label for="title">
                        Título *
                    </label>

                    <input
                        id="title"
                        name="title"
                        type="text"
                        value="{{ old('title', $book->title) }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="author">
                        Autor *
                    </label>

                    <input
                        id="author"
                        name="author"
                        type="text"
                        value="{{ old('author', $book->author) }}"
                        required
                    >

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
                    >

                </div>


                <div class="form-group">

                    <label for="publication_year">
                        Ano
                    </label>

                    <input
                        id="publication_year"
                        name="publication_year"
                        type="number"
                        value="{{ old('publication_year', $book->publication_year) }}"
                        min="1000"
                        max="{{ date('Y') }}"
                    >

                </div>


                <div class="form-group">

                    <label for="isbn">
                        ISBN
                    </label>

                    <input
                        id="isbn"
                        name="isbn"
                        type="text"
                        value="{{ old('isbn', $book->isbn) }}"
                    >

                </div>


                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option
                            value="want_to_read"
                            @selected(old('status', $book->status) === 'want_to_read')
                        >
                            📕 Quero ler
                        </option>

                        <option
                            value="reading"
                            @selected(old('status', $book->status) === 'reading')
                        >
                            📖 Lendo
                        </option>

                        <option
                            value="read"
                            @selected(old('status', $book->status) === 'read')
                        >
                            ✅ Lido
                        </option>

                        <option
                            value="paused"
                            @selected(old('status', $book->status) === 'paused')
                        >
                            ⏸️ Pausado
                        </option>

                        <option
                            value="abandoned"
                            @selected(old('status', $book->status) === 'abandoned')
                        >
                            ❌ Abandonei
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="pages">
                        Total de páginas
                    </label>

                    <input
                        id="pages"
                        name="pages"
                        type="number"
                        min="1"
                        value="{{ old('pages', $book->pages) }}"
                    >

                </div>


                <div class="form-group">

                    <label for="current_page">
                        Página atual
                    </label>

                    <input
                        id="current_page"
                        name="current_page"
                        type="number"
                        min="0"
                        value="{{ old('current_page', $book->current_page) }}"
                    >

                </div>


                <div class="form-group full">

                    <label for="description">
                        Sinopse / Anotações
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                    >{{ old('description', $book->description) }}</textarea>

                </div>

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

@endsection