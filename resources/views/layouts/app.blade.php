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

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
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
               @if(request()->routeIs('books.index')) aria-current="page" @endif>
                Acervo
            </a>
            <a href="{{ route('books.create') }}"
               class="{{ request()->routeIs('books.create') ? 'active' : '' }}"
               @if(request()->routeIs('books.create')) aria-current="page" @endif>
                Novo livro
            </a>
        </nav>

        <div class="topbar-actions">
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
    @if(session('success'))
        <div class="alert alert-success" role="status" aria-live="polite">
            <div class="alert-icon" aria-hidden="true">✓</div>
            <div>
                <strong>Sucesso</strong>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error" role="alert">
            <div class="alert-icon" aria-hidden="true">!</div>
            <div>
                <strong>Verifique as informações</strong>
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

<script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}" defer></script>
</body>
</html>