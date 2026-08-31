@extends('layouts.app')

@section('title', $book->title . ' | BookList')

@section('content')


<div class="page-header">

    <div>

        <span class="eyebrow">
            DETALHES DO LIVRO
        </span>

        <h1 class="page-title">
            {{ $book->title }}
        </h1>

        <p class="page-description">
            Informações completas da sua leitura.
        </p>

    </div>


    <a
        href="{{ route('books.index') }}"
        class="btn-clear"
    >
        ← Voltar
    </a>

</div>


<section class="book-detail-card">


    <div class="book-detail-cover">

        @if($book->cover)

            <img
                src="{{ asset('storage/' . $book->cover) }}"
                alt="{{ $book->title }}"
            >

        @else

            <div class="detail-cover-placeholder">
                📚
            </div>

        @endif

    </div>


    <div class="book-detail-content">


        <div class="detail-heading">

            <div>

                <span class="status-badge {{ $book->status_class }}">

                    {{ $book->status_icon }}

                    {{ $book->status_label }}

                </span>

                <h2>
                    {{ $book->title }}
                </h2>

                <p>
                    por {{ $book->author }}
                </p>

            </div>


            <form
                action="{{ route('books.favorite', $book) }}"
                method="POST"
            >

                @csrf
                @method('PATCH')

                <button
                    class="detail-favorite"
                    type="submit"
                >
                    {{ $book->favorite ? '❤️' : '🤍' }}
                </button>

            </form>

        </div>


        <div class="detail-rating">

            @for($i = 1; $i <= 5; $i++)

                <span class="{{ ($book->rating ?? 0) >= $i ? 'star-filled' : 'star-empty' }}">
                    ★
                </span>

            @endfor

            <span>
                {{ $book->rating ? $book->rating . '/5' : 'Não avaliado' }}
            </span>

        </div>


        @if($book->pages)

            <div class="detail-progress">

                <div class="progress-info">

                    <span>
                        Progresso da leitura
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

                    {{ $book->current_page }}

                    de

                    {{ $book->pages }}

                    páginas

                </small>

            </div>

        @endif


        <div class="book-information-grid">

            <div>

                <span>Autor</span>

                <strong>
                    {{ $book->author }}
                </strong>

            </div>


            <div>

                <span>Gênero</span>

                <strong>
                    {{ $book->genre ?: 'Não informado' }}
                </strong>

            </div>


            <div>

                <span>Publicação</span>

                <strong>
                    {{ $book->publication_year ?: 'Não informado' }}
                </strong>

            </div>


            <div>

                <span>ISBN</span>

                <strong>
                    {{ $book->isbn ?: 'Não informado' }}
                </strong>

            </div>

        </div>


        <div class="book-description">

            <h3>
                Sinopse / Anotações
            </h3>

            <p>
                {{ $book->description ?: 'Nenhuma descrição cadastrada.' }}
            </p>

        </div>



    </div>

</section>


@endsection