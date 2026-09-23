@extends('layouts.app')

@section('title', 'Cadastrar livro | BookList')

@section('content')
<section class="page-heading">
    <div>
        <span class="eyebrow">CADASTRO DO ACERVO</span>
        <h1>Novo livro</h1>
        <p>Adicione um novo livro à biblioteca escolar.</p>
    </div>

    <a href="{{ route('books.index') }}" class="btn btn-secondary" data-loading-link="Voltando ao acervo...">Voltar</a>
</section>

<section class="form-layout">
    <div class="panel form-panel">
        <div class="form-panel-header">
            <div class="form-panel-icon" aria-hidden="true">B</div>
            <div>
                <h2>Informações do livro</h2>
                <p>Preencha os dados bibliográficos e informações de leitura.</p>
            </div>
        </div>

        @include('books._form', [
            'book' => null,
            'action' => route('books.store'),
            'method' => 'POST',
            'cancelUrl' => route('books.index'),
            'submitLabel' => 'Salvar livro',
        ])
    </div>

    <aside class="panel tips-panel" aria-label="Boas práticas de cadastro">
        <h3>Boas práticas</h3>
        <p class="tips-intro">Informações completas deixam o acervo mais organizado e fácil de pesquisar.</p>

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