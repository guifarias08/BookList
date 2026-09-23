@extends('layouts.app')

@section('title', 'Editar livro | BookList')

@section('content')
<section class="page-heading">
    <div>
        <span class="eyebrow">MANUTENÇÃO DO ACERVO</span>
        <h1>Editar livro</h1>
        <p>Atualize os dados e o progresso de leitura.</p>
    </div>

    <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">Voltar</a>
</section>

<section class="form-layout">
    <div class="panel form-panel">
        <div class="form-panel-header">
            <div class="form-panel-icon" aria-hidden="true">E</div>
            <div>
                <h2>{{ $book->title }}</h2>
                <p>Atualize as informações cadastradas.</p>
            </div>
        </div>

        @include('books._form', [
            'book' => $book,
            'action' => route('books.update', $book),
            'method' => 'PUT',
            'cancelUrl' => route('books.show', $book),
            'submitLabel' => 'Salvar alterações',
        ])
    </div>

    <aside class="panel danger-panel">
        <h3>Zona administrativa</h3>
        <p>A exclusão remove permanentemente o livro do acervo.</p>

        <form action="{{ route('books.destroy', $book) }}"
              method="POST"
              data-confirm-delete="Tem certeza que deseja excluir este livro? Esta ação não pode ser desfeita.">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Excluir livro</button>
        </form>
    </aside>
</section>
@endsection