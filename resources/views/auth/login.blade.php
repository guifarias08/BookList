<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Acesse o BookList para gerenciar o acervo da biblioteca escolar.">
    <meta name="color-scheme" content="light dark">
    <title>Entrar | BookList</title>

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
<body class="auth-body">
    <main class="auth-page">
        <section class="auth-showcase" aria-hidden="true">
            <div class="auth-showcase-content">
                <div class="auth-brand-large">
                    <div class="auth-brand-mark">B</div>
                    <div>
                        <strong>BookList</strong>
                        <span>Biblioteca Escolar</span>
                    </div>
                </div>

                <div class="auth-copy">
                    <span class="auth-kicker">SEU ACERVO, SEM COMPLICAÇÃO</span>
                    <h1>Organize leituras.<br>Acompanhe progresso.<br>Encontre tudo rápido.</h1>
                    <p>Uma experiência simples para cuidar do acervo e manter cada leitura sob controle.</p>
                </div>

                <div class="auth-feature-grid">
                    <article>
                        <span>01</span>
                        <strong>Acervo organizado</strong>
                        <small>Livros, autores e gêneros em um só lugar.</small>
                    </article>
                    <article>
                        <span>02</span>
                        <strong>Progresso de leitura</strong>
                        <small>Acompanhe páginas, status e avaliações.</small>
                    </article>
                    <article>
                        <span>03</span>
                        <strong>Acesso protegido</strong>
                        <small>Seus dados ficam disponíveis somente após o login.</small>
                    </article>
                </div>
            </div>

            <div class="auth-orbit auth-orbit-one"></div>
            <div class="auth-orbit auth-orbit-two"></div>
        </section>

        <section class="auth-panel">
            <div class="auth-panel-top">
                <a href="{{ route('login') }}" class="auth-mobile-brand" aria-label="BookList">
                    <span>B</span>
                    <strong>BookList</strong>
                </a>

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
            </div>

            <div class="auth-form-shell">
                <div class="auth-form-heading">
                    <span class="eyebrow">ÁREA RESTRITA</span>
                    <h2>Bem-vindo de volta</h2>
                    <p>Entre com sua conta para acessar o acervo.</p>
                </div>

                <form action="{{ route('login.attempt') }}"
                      method="POST"
                      class="auth-form"
                      novalidate>
                    @csrf

                    <div class="field auth-field">
                        <label for="email">E-mail</label>
                        <div class="auth-input-wrap">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4 6h16v12H4z"/>
                                <path d="m4 7 8 6 8-6"/>
                            </svg>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="seuemail@exemplo.com"
                                   autocomplete="email"
                                   autofocus
                                   required
                                   @error('email') aria-invalid="true" @enderror>
                        </div>
                        @error('email')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="field auth-field">
                        <label for="password">Senha</label>
                        <div class="auth-input-wrap">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="5" y="10" width="14" height="10" rx="2"/>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                            </svg>

                            <input type="password"
                                   id="password"
                                   name="password"
                                   placeholder="Digite sua senha"
                                   autocomplete="current-password"
                                   required
                                   @error('password') aria-invalid="true" @enderror>

                            <button type="button"
                                    id="passwordToggle"
                                    class="password-toggle"
                                    aria-label="Mostrar senha">
                                <svg class="eye-open" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                    <circle cx="12" cy="12" r="2.5"/>
                                </svg>
                                <svg class="eye-closed" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="m3 3 18 18"/>
                                    <path d="M10.6 6.2A9.3 9.3 0 0 1 12 6c6 0 9.5 6 9.5 6a15.8 15.8 0 0 1-2.1 2.7M6.2 6.2C3.8 7.8 2.5 12 2.5 12s3.5 6 9.5 6a9 9 0 0 0 3.2-.6"/>
                                </svg>
                            </button>
                        </div>

                        <small id="capsLockHint" class="caps-lock-hint" hidden>Caps Lock está ativado.</small>

                        @error('password')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="auth-options">
                        <label class="remember-check">
                            <input type="checkbox"
                                   name="remember"
                                   value="1"
                                   @checked(old('remember'))>
                            <span>Lembrar de mim</span>
                        </label>

                        <span class="auth-security-note">Acesso seguro</span>
                    </div>

                    <button type="submit" class="btn btn-primary auth-submit">
                        <span>Entrar no BookList</span>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </button>
                </form>

                <p class="auth-footer-note">
                    BookList · Biblioteca Escolar
                </p>
            </div>
        </section>
    </main>

    <div id="globalLoader"
         class="global-loader auth-loader"
         aria-hidden="true"
         role="status"
         aria-live="polite">
        <div class="global-loader-card">
            <span class="loader-ring" aria-hidden="true"></span>
            <div>
                <strong id="globalLoaderTitle">Autenticando</strong>
                <span id="globalLoaderText">Validando seus dados...</span>
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
