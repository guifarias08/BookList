@extends('layouts.app')

@section('title', 'Adicionar livro | BookList')

@section('content')

<div class="page-header">

    <div>
        <span class="eyebrow">
            NOVO LIVRO
        </span>

        <h1 class="page-title">
            Adicionar livro
        </h1>

        <p class="page-description">
            Cadastre um novo livro na sua biblioteca.
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
            📚
        </div>

        <div>
            <h2>Informações do livro</h2>

            <p>
                Adicione os dados, capa e informações da leitura.
            </p>
        </div>

    </div>


    <form
        action="{{ route('books.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf


        <div class="book-form-layout">


            <div class="cover-upload-area">

                <div class="cover-preview">

                    <img
                        id="coverPreview"
                        class="cover-preview-image hidden"
                        alt="Prévia da capa"
                    >

                    <div
                        id="coverPlaceholder"
                        class="cover-placeholder"
                    >
                        📚

                        <span>
                            Capa do livro
                        </span>
                    </div>

                </div>


                <label
                    for="cover"
                    class="cover-upload-button"
                >
                    📷 Escolher capa
                </label>

                <input
                    id="cover"
                    name="cover"
                    type="file"
                    accept="image/png,image/jpeg,image/webp"
                    class="hidden"
                >

                @error('cover')
                    <small class="form-error">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            <div class="form-grid">

                <div class="form-group full">

                    <label for="title">
                        Título <span>*</span>
                    </label>

                    <input
                        id="title"
                        name="title"
                        type="text"
                        value="{{ old('title') }}"
                        placeholder="Ex.: Harry Potter"
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
                        value="{{ old('author') }}"
                        placeholder="Ex.: J. K. Rowling"
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
                        value="{{ old('genre') }}"
                        placeholder="Ex.: Fantasia"
                    >

                    @error('genre')
                        <small>{{ $message }}</small>
                    @enderror

                </div>


                <div class="form-group">

                    <label for="publication_year">
                        Ano
                    </label>

                    <input
                        id="publication_year"
                        name="publication_year"
                        type="number"
                        value="{{ old('publication_year') }}"
                        min="1000"
                        max="{{ date('Y') }}"
                        placeholder="Ex.: 1997"
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
                        value="{{ old('isbn') }}"
                        placeholder="Ex.: 9788532530783"
                    >

                </div>


                <div class="form-group">

                    <label for="status">
                        Status <span>*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option
                            value="want_to_read"
                            @selected(old('status', 'want_to_read') === 'want_to_read')
                        >
                            📕 Quero ler
                        </option>

                        <option
                            value="reading"
                            @selected(old('status') === 'reading')
                        >
                            📖 Lendo
                        </option>

                        <option
                            value="read"
                            @selected(old('status') === 'read')
                        >
                            ✅ Lido
                        </option>

                        <option
                            value="paused"
                            @selected(old('status') === 'paused')
                        >
                            ⏸️ Pausado
                        </option>

                        <option
                            value="abandoned"
                            @selected(old('status') === 'abandoned')
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
                        value="{{ old('pages') }}"
                        placeholder="Ex.: 320"
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
                        value="{{ old('current_page', 0) }}"
                    >

                    @error('current_page')
                        <small>{{ $message }}</small>
                    @enderror

                </div>


                <div class="form-group full">

                    <label for="description">
                        Sinopse / Anotações
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        placeholder="Escreva uma descrição, sinopse ou suas anotações..."
                    >{{ old('description') }}</textarea>

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
                ✓ Salvar livro
            </button>

        </div>

    </form>

</section>

@endsection