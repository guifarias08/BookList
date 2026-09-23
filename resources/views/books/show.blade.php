@extends('layouts.app')

@section('title', $book->title . ' | BookList')

@section('content')
@php
    $progress = ($book->pages ?? 0) > 0
        ? min(100, round((($book->current_page ?? 0) / $book->pages) * 100))
        : 0;
@endphp

<section class="page-heading">
    <div>
        <span class="eyebrow">DETALHES DO LIVRO</span>
        <h1>{{ $book->title }}</h1>
        <p>Consulte os dados bibliográficos e o progresso da leitura.</p>
    </div>

    <div class="heading-actions">
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Acervo</a>
        <a href="{{ route('books.edit', $book) }}" class="btn btn-primary">Editar livro</a>
    </div>
</section>

<section class="details-grid">
    <div class="panel book-detail-main">
        <div class="book-profile">
            <div class="book-cover-large">
                @if($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Capa de {{ $book->title }}">
                @else
                    <span aria-hidden="true">{{ strtoupper(substr($book->title, 0, 1)) }}</span>
                @endif
            </div>

            <div class="book-profile-info">
                <div class="book-status-row">
                    <x-status-badge :status="$book->status" />
                    @if($book->favorite)
                        <span class="favorite-badge">★ Favorito</span>
                    @endif
                </div>

                <h2>{{ $book->title }}</h2>
                <p class="author-name">{{ $book->author }}</p>

                <div class="book-metadata">
                    <div><span>Gênero</span><strong>{{ $book->genre ?: 'Não informado' }}</strong></div>
                    <div><span>Ano</span><strong>{{ $book->publication_year ?: 'Não informado' }}</strong></div>
                    <div><span>ISBN</span><strong>{{ $book->isbn ?: 'Não informado' }}</strong></div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h3>Progresso da leitura</h3>

            @if(($book->pages ?? 0) > 0)
                <div class="reading-progress">
                    <div class="reading-progress-header">
                        <strong>{{ $book->current_page ?? 0 }} de {{ $book->pages }} páginas</strong>
                        <span>{{ $progress }}%</span>
                    </div>
                    <div class="progress-track large" aria-label="Progresso de leitura: {{ $progress }}%">
                        <span style="width: {{ $progress }}%"></span>
                    </div>
                </div>
            @else
                <p class="muted">Nenhuma informação de páginas cadastrada.</p>
            @endif
        </div>

        <div class="detail-section">
            <h3>Sinopse / Anotações</h3>
            <p class="description-text">{{ $book->description ?: 'Nenhuma anotação cadastrada.' }}</p>
        </div>
    </div>

    <aside class="details-sidebar">
        <div class="panel rating-panel">
            <h3>Avaliação</h3>
            <p>Dê uma nota de 1 a 5 para este livro.</p>

            <form action="{{ route('books.rating', $book) }}" method="POST" class="rating-form">
                @csrf
                @method('PATCH')

                <fieldset class="rating-fieldset">
                    <legend class="sr-only">Nota do livro</legend>
                    <div class="rating-options">
                        @for($i = 1; $i <= 5; $i++)
                            <label for="rating-{{ $i }}">
                                <input type="radio"
                                       id="rating-{{ $i }}"
                                       name="rating"
                                       value="{{ $i }}"
                                       @checked($book->rating == $i)>
                                <span>{{ $i }}</span>
                            </label>
                        @endfor
                    </div>
                </fieldset>

                <button type="submit" class="btn btn-primary">Salvar avaliação</button>
            </form>

            @if($book->rating)
                <div class="rating-result">
                    <span>Nota atual</span>
                    <strong>{{ $book->rating }}/5</strong>
                </div>
            @endif
        </div>

        <div class="panel quick-info">
            <div class="quick-info-title">
                <h3>Informações rápidas</h3>
                <form action="{{ route('books.favorite', $book) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="favorite-toggle {{ $book->favorite ? 'is-favorite' : '' }}"
                            aria-label="{{ $book->favorite ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}">
                        {{ $book->favorite ? '★' : '☆' }}
                    </button>
                </form>
            </div>

            <div class="quick-info-row"><span>Status</span><x-status-badge :status="$book->status" /></div>
            <div class="quick-info-row"><span>Páginas</span><strong>{{ $book->pages ?: '—' }}</strong></div>
            <div class="quick-info-row"><span>Página atual</span><strong>{{ $book->current_page ?? 0 }}</strong></div>
            <div class="quick-info-row"><span>Cadastro</span><strong>{{ $book->created_at->format('d/m/Y') }}</strong></div>
        </div>
    </aside>
</section>
@endsection