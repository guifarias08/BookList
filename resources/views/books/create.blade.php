@extends('layouts.app')

@section('title', 'Cadastrar livro | BookList')

@section('content')


<section class="page-heading">

    <div>

        <span class="eyebrow">
            CADASTRO DO ACERVO
        </span>

        <h1>
            Novo livro
        </h1>

        <p>
            Adicione um novo livro à biblioteca escolar.
        </p>

    </div>


    <a
        href="{{ route('books.index') }}"
        class="btn btn-secondary"
    >
        ← Voltar
    </a>

</section>


<section class="form-layout">


    <div class="panel form-panel">

        <div class="form-panel-header">

            <div class="form-panel-icon">
                B
            </div>

            <div>

                <h2>
                    Informações do livro
                </h2>

                <p>
                    Preencha os dados bibliográficos e informações de leitura.
                </p>

            </div>

        </div>


        <form
            action="{{ route('books.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="cover-area">

                <div
                    class="cover-preview"
                    id="coverPreview"
                >

                    <div class="cover-placeholder">

                        <strong>B</strong>

                        <span>
                            Prévia da capa
                        </span>

                    </div>

                </div>


                <div class="cover-upload">

                    <label for="cover">
                        Capa do livro
                    </label>

                    <input
                        type="file"
                        id="cover"
                        name="cover"
                        accept="image/*"
                    >

                    <small>
                        JPG, PNG ou WEBP. Máximo recomendado: 2 MB.
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
                        value="{{ old('title') }}"
                        placeholder="Ex.: Dom Casmurro"
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
                        value="{{ old('author') }}"
                        placeholder="Ex.: Machado de Assis"
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
                        value="{{ old('genre') }}"
                        placeholder="Ex.: Romance"
                    >

                </div>


                <div class="field">

                    <label for="publication_year">
                        Ano de publicação
                    </label>

                    <input
                        type="number"
                        id="publication_year"
                        name="publication_year"
                        value="{{ old('publication_year') }}"
                        placeholder="Ex.: 1899"
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
                        value="{{ old('isbn') }}"
                        placeholder="Ex.: 9788532530783"
                    >

                </div>


                <div class="field">

                    <label for="status">
                        Status de leitura *
                    </label>

                    <select
                        name="status"
                        id="status"
                        required
                    >

                        <option
                            value="want_to_read"
                            @selected(old('status', 'want_to_read') === 'want_to_read')
                        >
                            Quero ler
                        </option>

                        <option
                            value="reading"
                            @selected(old('status') === 'reading')
                        >
                            Lendo
                        </option>

                        <option
                            value="read"
                            @selected(old('status') === 'read')
                        >
                            Concluído
                        </option>

                        <option
                            value="paused"
                            @selected(old('status') === 'paused')
                        >
                            Pausado
                        </option>

                        <option
                            value="abandoned"
                            @selected(old('status') === 'abandoned')
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
                        value="{{ old('total_pages') }}"
                        placeholder="Ex.: 320"
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
                        value="{{ old('current_page', 0) }}"
                        placeholder="0"
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
                        placeholder="Escreva uma sinopse, descrição ou observação..."
                    >{{ old('description') }}</textarea>

                </div>

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('books.index') }}"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Salvar livro
                </button>

            </div>

        </form>

    </div>


    <aside class="panel tips-panel">

        <h3>
            Boas práticas
        </h3>

        <p class="tips-intro">
            Informações completas deixam o acervo mais organizado.
        </p>


        <div class="tip">

            <span>01</span>

            <div>
                <strong>Título e autor</strong>
                <p>Use os nomes completos para facilitar pesquisas.</p>
            </div>

        </div>


        <div class="tip">

            <span>02</span>

            <div>
                <strong>ISBN</strong>
                <p>Ajuda a identificar corretamente cada edição.</p>
            </div>

        </div>


        <div class="tip">

            <span>03</span>

            <div>
                <strong>Progresso</strong>
                <p>Informe as páginas para acompanhar sua leitura.</p>
            </div>

        </div>

    </aside>


</section>

@endsection