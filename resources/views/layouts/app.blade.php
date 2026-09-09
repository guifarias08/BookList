<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>@yield('title', 'BookList')</title>

    <script>
        (function () {
            const theme = localStorage.getItem('booklist-theme');

            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}"
    >
</head>

<body>

<header class="topbar">

    <div class="topbar-inner">

        <a
            href="{{ route('books.index') }}"
            class="brand"
        >

            <div class="brand-logo">
                B
            </div>

            <div class="brand-text">
                <strong>BookList</strong>
                <span>Biblioteca Escolar</span>
            </div>

        </a>


        <nav
            class="main-nav"
            id="mainNav"
        >

            <a
                href="{{ route('books.index') }}"
                class="{{ request()->routeIs('books.index') ? 'active' : '' }}"
            >
                Acervo
            </a>

            <a
                href="{{ route('books.create') }}"
                class="{{ request()->routeIs('books.create') ? 'active' : '' }}"
            >
                Novo livro
            </a>

        </nav>


        <div class="topbar-actions">

            <button
                type="button"
                id="themeToggle"
                class="theme-toggle"
                aria-label="Alternar tema"
            >
                🌙
            </button>

        </div>


        <button
            type="button"
            id="menuButton"
            class="menu-button"
        >
            ☰
        </button>

    </div>

</header>


<main class="app-shell">

    @if(session('success'))

        <div class="alert alert-success">

            <div class="alert-icon">
                ✓
            </div>

            <div>
                <strong>Sucesso</strong>
                <p>{{ session('success') }}</p>
            </div>

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-error">

            <div class="alert-icon">
                !
            </div>

            <div>

                <strong>
                    Verifique as informações
                </strong>

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


<script
    src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"
></script>

</body>
</html>