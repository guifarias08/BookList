<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BookList - organização e acompanhamento do acervo da biblioteca escolar.">
    <meta name="color-scheme" content="light dark">
    <title>@yield('title', 'BookList')</title>

    <script>
        (() => {
            const savedTheme = localStorage.getItem('booklist-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const shouldUseDark = savedTheme ? savedTheme === 'dark' : prefersDark;
            document.documentElement.classList.toggle('dark', shouldUseDark);
        })();
    </script>

    @if(file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    @endif
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a href="{{ route('books.index') }}" class="brand" aria-label="BookList - ir para o acervo">
            <div class="brand-logo" aria-hidden="true">B</div>
            <div class="brand-text">
                <strong>BookList</strong>
                <span>Biblioteca Escolar</span>
            </div>
        </a>

        <nav class="main-nav" id="mainNav" aria-label="Navegação principal">
            <a href="{{ route('books.index') }}"
               class="{{ request()->routeIs('books.index') ? 'active' : '' }}"
               @if(request()->routeIs('books.index')) aria-current="page" @endif
               data-loading-link="Abrindo o acervo...">
                Acervo
            </a>

            <a href="{{ route('books.create') }}"
               class="{{ request()->routeIs('books.create') ? 'active' : '' }}"
               @if(request()->routeIs('books.create')) aria-current="page" @endif
               data-loading-link="Abrindo o cadastro...">
                Novo livro
            </a>
        </nav>

        <div class="topbar-actions">
            @auth
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-button" aria-label="Sair da conta">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 5H5v14h4M13 8l4 4-4 4M17 12H9"/>
                        </svg>
                        <span>Sair</span>
                    </button>
                </form>
            @endauth

            <button type="button"
                    id="themeToggle"
                    class="icon-button theme-toggle"
                    aria-label="Alternar tema"
                    aria-pressed="false">
                <svg class="moon-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.5 14.2A8.5 8.5 0 0 1 9.8 3.5 8.5 8.5 0 1 0 20.5 14.2Z"/>
                </svg>
                <svg class="sun-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="4"/>
                    <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                </svg>
            </button>

            <button type="button"
                    id="menuButton"
                    class="icon-button menu-button"
                    aria-label="Abrir menu"
                    aria-controls="mainNav"
                    aria-expanded="false">
                <span class="menu-lines" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</header>

<main class="app-shell">
    @yield('content')
</main>

<div id="globalLoader"
     class="global-loader"
     aria-hidden="true"
     role="status"
     aria-live="polite">
    <div class="global-loader-card">
        <span class="loader-ring" aria-hidden="true"></span>
        <div>
            <strong id="globalLoaderTitle">Só um instante</strong>
            <span id="globalLoaderText">Processando...</span>
        </div>
    </div>
</div>

<div id="toastFallbackStack" class="toast-fallback-stack" aria-live="polite"></div>

<script>
    window.bookListFlash = {
        success: @json(session('success')),
        error: @json(session('error')),
        warning: @json(session('warning')),
        info: @json(session('info')),
        errors: @json($errors->all())
    };
</script>

@unless(file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}" defer></script>
@endunless
</body>
</html>