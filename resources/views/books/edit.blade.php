@extends('layouts.app')

@section('title', 'Editar livro | BookList')

@section('content')


<section class="page-heading">

    <div>

        <span class="eyebrow">
            MANUTENÇÃO DO ACERVO
        </span>

        <h1>
            Editar livro
        </h1>

        <p>
            Atualize os dados e o progresso de leitura.
        </p>

    </div>


    <a
        href="{{ route('books.show', $book) }}"
        class="btn btn-secondary"
    >
        ← Voltar
    </a>

</section>


<section class="form-layout">


    <div class="panel form-panel">

        <div class="form-panel-header">

            <div class="form-panel-icon">
                E
            </div>

            <div>

                <h2>
                    {{ $book->title }}
                </h2>

                <p>
                    Atualize as informações cadastradas.
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


            <div class="cover-area">

                <div
                    class="cover-preview"
                    id="coverPreview"
                >

                    @if($book->cover)

                        <img
                            src="{{ asset('storage/' . $book->cover) }}"
                            alt="{{ $book->title }}"
                        >

                    @else

                        <div class="cover-placeholder">

                            <strong>
                                {{ strtoupper(substr($book->title, 0, 1)) }}
                            </strong>

                            <span>
                                Sem capa
                            </span>

                        </div>

                    @endif

                </div>


                <div class="cover-upload">

                    <label for="cover">
                        Alterar capa
                    </label>

                    <input
                        type="file"
                        id="cover"
                        name="cover"
                        accept="image/*"
                    >

                    <small>
                        Deixe vazio para manter a capa atual.
                    </small>

                </div>

            </div>


            <div class="form-grid">


                <div class="field full">

                    <label for="title">
                        Título *
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $book->title) }}"
                        required
                    >

                </div>


                <div class="field">

                    <label for="author">
                        Autor *
                    </label>

                    <input
                        type="text"
                        id="author"
                        name="author"
                        value="{{ old('author', $book->author) }}"
                        required
                    >

                </div>


                <div class="field">

                    <label for="genre">
                        Gênero
                    </label>

                    <input
                        type="text"
                        id="genre"
                        name="genre"
                        value="{{ old('genre', $book->genre) }}"
                    >

                </div>


                <div class="field">

                    <label for="publication_year">
                        Ano
                    </label>

                    <input
                        type="number"
                        id="publication_year"
                        name="publication_year"
                        value="{{ old('publication_year', $book->publication_year) }}"
                    >

                </div>


                <div class="field">

                    <label for="isbn">
                        ISBN
                    </label>

                    <input
                        type="text"
                        id="isbn"
                        name="isbn"
                        value="{{ old('isbn', $book->isbn) }}"
                    >

                </div>


                <div class="field">

                    <label for="status">
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                    >

                        <option
                            value="want_to_read"
                            @selected(old('status', $book->status) === 'want_to_read')
                        >
                            Quero ler
                        </option>

                        <option
                            value="reading"
                            @selected(old('status', $book->status) === 'reading')
                        >
                            Lendo
                        </option>

                        <option
                            value="read"
                            @selected(old('status', $book->status) === 'read')
                        >
                            Concluído
                        </option>

                        <option
                            value="paused"
                            @selected(old('status', $book->status) === 'paused')
                        >
                            Pausado
                        </option>

                        <option
                            value="abandoned"
                            @selected(old('status', $book->status) === 'abandoned')
                        >
                            Abandonado
                        </option>

                    </select>

                </div>


                <div class="field">

                    <label for="total_pages">
                        Total de páginas
                    </label>

                    <input
                        type="number"
                        id="total_pages"
                        name="total_pages"
                        value="{{ old('total_pages', $book->total_pages) }}"
                        min="0"
                    >

                </div>


                <div class="field">

                    <label for="current_page">
                        Página atual
                    </label>

                    <input
                        type="number"
                        id="current_page"
                        name="current_page"
                        value="{{ old('current_page', $book->current_page) }}"
                        min="0"
                    >

                </div>


                <div class="field full">

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


            <div class="form-actions">

                <a
                    href="{{ route('books.show', $book) }}"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Salvar alterações
                </button>

            </div>

        </form>

    </div>


    <aside class="panel danger-panel">

        <h3>Zona administrativa</h3>

        <p>
            A exclusão remove permanentemente o livro do acervo.
        </p>


        <form
            action="{{ route('books.destroy', $book) }}"
            method="POST"
            onsubmit="return confirm('Deseja realmente excluir este livro?')"
        >

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn btn-danger"
            >
                Excluir livro
            </button>

        </form>

    </aside>


</section>

@endsection