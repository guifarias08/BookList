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
                Preencha os dados abaixo para adicionar um novo livro.
            </p>

        </div>

    </div>


    <form
        action="{{ route('books.store') }}"
        method="POST"
        id="bookForm"
    >

        @csrf


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
                    value="{{ old('author') }}"
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
                    value="{{ old('genre') }}"
                    placeholder="Ex.: Ficção"
                >

                @error('genre')
                    <small>{{ $message }}</small>
                @enderror

            </div>
                <div class="form-group">

                <label for="status">
                    Status de leitura <span>*</span>
                </label>

                <select id="status" name="status" required>

                    <option value="want_to_read"
                        @selected(old('status', 'want_to_read') === 'want_to_read')}>
                        📕 Quero ler
                    </option>

                    <option value="reading"
                        @selected(old('status') === 'reading')}>
                        📖 Lendo
                    </option>

                    <option value="read"
                        @selected(old('status') === 'read')}>
                        ✅ Lido
                    </option>

                    <option value="paused"
                        @selected(old('status') === 'paused')}>
                        ⏸️ Pausado
                    </option>

                    <option value="abandoned"
                        @selected(old('status') === 'abandoned')}>
                        ❌ Abandonei
                    </option>

                </select>

                @error('status')
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
                    value="{{ old('publication_year') }}"
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
                ✓ Salvar livro
            </button>

        </div>

    </form>

</section>

@endsection