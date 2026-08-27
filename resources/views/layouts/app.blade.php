<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'BookList')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
    >
</head>

<body>

<header class="navbar">

    <div class="navbar-container">

        <a
            href="{{ route('books.index') }}"
            class="logo"
        >
            <span class="logo-icon">📚</span>
            <span>BookList</span>
        </a>

        <button
            class="mobile-menu-button"
            id="mobileMenuButton"
            type="button"
            aria-label="Abrir menu"
        >
            ☰
        </button>

        <nav class="nav-links" id="navLinks">

            <a
                href="{{ route('books.index') }}"
                class="nav-link {{ request()->routeIs('books.index') ? 'active' : '' }}"
            >
                Início
            </a>

            <a
                href="{{ route('books.index') }}"
                class="nav-link {{ request()->routeIs('books.*') && !request()->routeIs('books.index') ? 'active' : '' }}"
            >
                Livros
            </a>

        </nav>

    </div>

</header>


<main class="container">

    @if(session('success'))

        <div class="toast toast-success" id="successToast">

            <span class="toast-icon">✓</span>

            <div>
                <strong>Sucesso!</strong>
                <p>{{ session('success') }}</p>
            </div>

            <button
                type="button"
                class="toast-close"
                onclick="closeToast()"
            >
                ×
            </button>

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-error">

            <div class="alert-icon">!</div>

            <div>

                <strong>Verifique os dados</strong>

                <ul>

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    @yield('content')

</main>


{{-- Modal de exclusão --}}
<div
    class="modal-overlay"
    id="deleteModal"
    aria-hidden="true"
>

    <div class="modal">

        <div class="modal-icon">
            🗑️
        </div>

        <h2>Excluir livro?</h2>

        <p>
            Essa ação não pode ser desfeita.
            O livro será removido permanentemente da sua biblioteca.
        </p>

        <div class="modal-actions">

            <button
                type="button"
                class="btn-cancel"
                id="cancelDelete"
            >
                Cancelar
            </button>

            <button
                type="button"
                class="btn-delete-confirm"
                id="confirmDelete"
            >
                Sim, excluir
            </button>

        </div>

    </div>

</div>


<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
