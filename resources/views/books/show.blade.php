@extends('layouts.app')

@section('title', $book->title . ' | BookList')

@section('content')


@php

    $progress = 0;

    if (($book->total_pages ?? 0) > 0) {

        $progress = min(
            100,
            round(
                (($book->current_page ?? 0)
                / $book->total_pages)
                * 100
            )
        );

    }

@endphp


<section class="page-heading">

    <div>

        <span class="eyebrow">
            DETALHES DO LIVRO
        </span>

        <h1>
            {{ $book->title }}
        </h1>

        <p>
            Consulte os dados bibliográficos e o progresso da leitura.
        </p>

    </div>


    <div class="heading-actions">

        <a
            href="{{ route('books.index') }}"
            class="btn btn-secondary"
        >
            ← Acervo
        </a>

        <a
            href="{{ route('books.edit', $book) }}"
            class="btn btn-primary"
        >
            Editar livro
        </a>

    </div>

</section>


<section class="details-grid">


    <div class="panel book-detail-main">

        <div class="book-profile">


            <div class="book-cover-large">

                @if($book->cover)

                    <img
                        src="{{ asset('storage/' . $book->cover) }}"
                        alt="{{ $book->title }}"
                    >

                @else

                    <span>
                        {{ strtoupper(substr($book->title, 0, 1)) }}
                    </span>

                @endif

            </div>


            <div class="book-profile-info">

                <span class="status-badge status-{{ $book->status }}">

                    @switch($book->status)

                        @case('want_to_read')
                            Quero ler
                            @break

                        @case('reading')
                            Lendo
                            @break

                        @case('read')
                            Concluído
                            @break

                        @case('paused')
                            Pausado
                            @break

                        @case('abandoned')
                            Abandonado
                            @break

                    @endswitch

                </span>


                <h2>
                    {{ $book->title }}
                </h2>


                <p class="author-name">
                    {{ $book->author }}
                </p>


                <div class="book-metadata">

                    <div>
                        <span>Gênero</span>
                        <strong>{{ $book->genre ?: 'Não informado' }}</strong>
                    </div>

                    <div>
                        <span>Ano</span>
                        <strong>{{ $book->publication_year ?: 'Não informado' }}</strong>
                    </div>

                    <div>
                        <span>ISBN</span>
                        <strong>{{ $book->isbn ?: 'Não informado' }}</strong>
                    </div>

                </div>

            </div>

        </div>


        <div class="detail-section">

            <h3>
                Progresso da leitura
            </h3>


            @if(($book->total_pages ?? 0) > 0)

                <div class="reading-progress">

                    <div class="reading-progress-header">

                        <strong>
                            {{ $book->current_page ?? 0 }}
                            de
                            {{ $book->total_pages }}
                            páginas
                        </strong>

                        <span>
                            {{ $progress }}%
                        </span>

                    </div>

                    <div class="progress-track large">

                        <span
                            style="width: {{ $progress }}%"
                        ></span>

                    </div>

                </div>

            @else

                <p class="muted">
                    Nenhuma informação de páginas cadastrada.
                </p>

            @endif

        </div>


        <div class="detail-section">

            <h3>
                Sinopse / Anotações
            </h3>

            <p class="description-text">
                {{ $book->description ?: 'Nenhuma anotação cadastrada.' }}
            </p>

        </div>

    </div>


    <aside class="details-sidebar">


        <div class="panel rating-panel">

            <h3>
                Avaliação
            </h3>

            <p>
                Dê uma nota de 1 a 5 para este livro.
            </p>


            <form
                action="{{ route('books.rating', $book) }}"
                method="POST"
                class="rating-form"
            >

                @csrf
                @method('PATCH')


                <div class="rating-options">

                    @for($i = 1; $i <= 5; $i++)

                        <label>

                            <input
                                type="radio"
                                name="rating"
                                value="{{ $i }}"
                                @checked($book->rating == $i)
                            >

                            <span>
                                {{ $i }}
                            </span>

                        </label>

                    @endfor

                </div>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Salvar avaliação
                </button>

            </form>


            @if($book->rating)

                <div class="rating-result">

                    Nota atual

                    <strong>
                        {{ $book->rating }}/5
                    </strong>

                </div>

            @endif

        </div>


        <div class="panel quick-info">

            <h3>
                Informações rápidas
            </h3>


            <div class="quick-info-row">
                <span>Status</span>

                <strong>
                    {{ ucfirst(str_replace('_', ' ', $book->status)) }}
                </strong>
            </div>


            <div class="quick-info-row">
                <span>Páginas</span>

                <strong>
                    {{ $book->total_pages ?: '—' }}
                </strong>
            </div>


            <div class="quick-info-row">
                <span>Página atual</span>

                <strong>
                    {{ $book->current_page ?? 0 }}
                </strong>
            </div>


            <div class="quick-info-row">
                <span>Cadastro</span>

                <strong>
                    {{ $book->created_at->format('d/m/Y') }}
                </strong>
            </div>

        </div>


    </aside>


</section>

@endsection