document.addEventListener('DOMContentLoaded', () => {

    // =====================================================
    // CONFIGURAÇÕES
    // =====================================================

    const LOADING_DELAY = 2000; // 2000ms = 2 segundos


    // =====================================================
    // ELEMENTOS
    // =====================================================

    const html = document.documentElement;

    const themeToggle =
        document.getElementById('themeToggle');

    const menuButton =
        document.getElementById('menuButton');

    const mainNav =
        document.getElementById('mainNav');

    const coverInput =
        document.getElementById('cover');

    const coverPreview =
        document.getElementById('coverPreview');

    const coverHint =
        document.getElementById('coverHint');

    const statusSelect =
        document.getElementById('status');

    const pagesInput =
        document.getElementById('pages');

    const currentPageInput =
        document.getElementById('current_page');

    const globalLoader =
        document.getElementById('globalLoader');

    const globalLoaderTitle =
        document.getElementById('globalLoaderTitle');

    const globalLoaderText =
        document.getElementById('globalLoaderText');

    const fallbackStack =
        document.getElementById('toastFallbackStack');

    const passwordInput =
        document.getElementById('password');

    const passwordToggle =
        document.getElementById('passwordToggle');

    const capsLockHint =
        document.getElementById('capsLockHint');


    // =====================================================
    // TEMA
    // =====================================================

    const syncThemeButton = () => {

        if (!themeToggle) {
            return;
        }

        const dark =
            html.classList.contains('dark');

        themeToggle.setAttribute(
            'aria-pressed',
            String(dark)
        );

        themeToggle.setAttribute(
            'aria-label',
            dark
                ? 'Ativar tema claro'
                : 'Ativar tema escuro'
        );

        themeToggle.title =
            dark
                ? 'Tema claro'
                : 'Tema escuro';
    };


    // =====================================================
    // MENU MOBILE
    // =====================================================

    const closeMenu = () => {

        if (!menuButton || !mainNav) {
            return;
        }

        mainNav.classList.remove('open');

        menuButton.setAttribute(
            'aria-expanded',
            'false'
        );

        menuButton.setAttribute(
            'aria-label',
            'Abrir menu'
        );
    };


    // =====================================================
    // LOADING GLOBAL
    // =====================================================

    const showLoader = (
        message = 'Processando...',
        title = 'Só um instante'
    ) => {

        if (!globalLoader) {
            return;
        }

        if (globalLoaderTitle) {
            globalLoaderTitle.textContent =
                title;
        }

        if (globalLoaderText) {
            globalLoaderText.textContent =
                message;
        }

        globalLoader.classList.add(
            'is-visible'
        );

        globalLoader.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.classList.add(
            'is-loading'
        );
    };


    const hideLoader = () => {

        if (!globalLoader) {
            return;
        }

        globalLoader.classList.remove(
            'is-visible'
        );

        globalLoader.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.classList.remove(
            'is-loading'
        );
    };


    // =====================================================
    // LOADING DO BOTÃO
    // =====================================================

    const setButtonLoading = (
        button,
        label
    ) => {

        if (
            !button ||
            button.dataset.loading === 'true'
        ) {
            return;
        }

        button.dataset.loading =
            'true';

        button.dataset.originalHtml =
            button.innerHTML;

        button.disabled =
            true;

        button.classList.add(
            'is-loading'
        );

        button.innerHTML = `
            <span
                class="button-spinner"
                aria-hidden="true"
            ></span>

            <span>
                ${label}
            </span>
        `;
    };


    // =====================================================
    // TOAST FALLBACK
    // =====================================================

    const showFallbackToast = (
        type,
        title,
        message
    ) => {

        if (
            !fallbackStack ||
            !message
        ) {
            return;
        }

        const toast =
            document.createElement('div');

        toast.className =
            `toast-fallback toast-fallback-${type}`;

        toast.setAttribute(
            'role',
            type === 'error'
                ? 'alert'
                : 'status'
        );


        // ÍCONE
        const icon =
            document.createElement('span');

        icon.className =
            'toast-fallback-icon';

        icon.textContent =
            type === 'success'
                ? '✓'
                : type === 'error'
                    ? '!'
                    : type === 'warning'
                        ? '!'
                        : 'i';


        // CONTEÚDO
        const content =
            document.createElement('div');

        const heading =
            document.createElement('strong');

        const text =
            document.createElement('span');

        heading.textContent =
            title;

        text.textContent =
            message;

        content.append(
            heading,
            text
        );


        // FECHAR
        const close =
            document.createElement('button');

        close.type =
            'button';

        close.className =
            'toast-fallback-close';

        close.setAttribute(
            'aria-label',
            'Fechar notificação'
        );

        close.textContent =
            '×';


        // MONTAGEM
        toast.append(
            icon,
            content,
            close
        );

        fallbackStack.appendChild(
            toast
        );


        requestAnimationFrame(() => {

            toast.classList.add(
                'is-visible'
            );

        });


        const removeToast = () => {

            toast.classList.remove(
                'is-visible'
            );

            setTimeout(
                () => toast.remove(),
                220
            );
        };


        close.addEventListener(
            'click',
            removeToast
        );


        // Tempo do toast fallback
        setTimeout(
            removeToast,
            4300
        );
    };


    // =====================================================
    // IZITOAST
    // =====================================================

    const showToast = (
        type,
        title,
        message
    ) => {

        if (!message) {
            return;
        }


        if (
            window.iziToast &&
            typeof window.iziToast[type] === 'function'
        ) {

            window.iziToast[type]({

                title: title,

                message: message,

                position:
                    'topRight',

                // Tempo que o toast fica aberto
                timeout:
                    4300,

                progressBar:
                    true,

                close:
                    true,

                drag:
                    true,

                pauseOnHover:
                    true,

                resetOnHover:
                    true,

                transitionIn:
                    'fadeInDown',

                transitionOut:
                    'fadeOutUp',

                layout:
                    2

            });

            return;
        }


        // Caso o iziToast não esteja carregado
        showFallbackToast(
            type,
            title,
            message
        );
    };


    // =====================================================
    // EVENTO DO TEMA
    // =====================================================

    if (themeToggle) {

        syncThemeButton();


        themeToggle.addEventListener(
            'click',
            () => {

                html.classList.toggle(
                    'dark'
                );


                const dark =
                    html.classList.contains(
                        'dark'
                    );


                localStorage.setItem(
                    'booklist-theme',
                    dark
                        ? 'dark'
                        : 'light'
                );


                syncThemeButton();

            }
        );
    }


    // =====================================================
    // MENU MOBILE
    // =====================================================

    if (
        menuButton &&
        mainNav
    ) {

        menuButton.addEventListener(
            'click',
            () => {

                const open =
                    mainNav.classList.toggle(
                        'open'
                    );


                menuButton.setAttribute(
                    'aria-expanded',
                    String(open)
                );


                menuButton.setAttribute(
                    'aria-label',
                    open
                        ? 'Fechar menu'
                        : 'Abrir menu'
                );

            }
        );


        mainNav
            .querySelectorAll('a')
            .forEach((link) => {

                link.addEventListener(
                    'click',
                    closeMenu
                );

            });


        document.addEventListener(
            'keydown',
            (event) => {

                if (
                    event.key === 'Escape'
                ) {
                    closeMenu();
                }

            }
        );


        window.addEventListener(
            'resize',
            () => {

                if (
                    window.innerWidth > 700
                ) {
                    closeMenu();
                }

            }
        );
    }


    // =====================================================
    // PREVIEW DA CAPA
    // =====================================================

    if (
        coverInput &&
        coverPreview
    ) {

        coverInput.addEventListener(
            'change',
            () => {

                const file =
                    coverInput.files?.[0];


                if (!file) {
                    return;
                }


                const validTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];


                const maxSize =
                    2 * 1024 * 1024;


                // TIPO OU TAMANHO INVÁLIDO
                if (
                    !validTypes.includes(
                        file.type
                    ) ||
                    file.size > maxSize
                ) {

                    coverInput.value =
                        '';


                    if (coverHint) {

                        coverHint.textContent =
                            file.size > maxSize
                                ? 'A imagem precisa ter no máximo 2 MB.'
                                : 'Use uma imagem JPG, PNG ou WEBP.';


                        coverHint.classList.add(
                            'field-error'
                        );
                    }


                    showToast(

                        'error',

                        'Capa inválida',

                        file.size > maxSize
                            ? 'Escolha uma imagem de até 2 MB.'
                            : 'Use apenas JPG, PNG ou WEBP.'

                    );


                    return;
                }


                // VOLTA TEXTO ORIGINAL
                if (coverHint) {

                    coverHint.textContent =
                        coverHint.dataset.defaultText ||
                        '';

                    coverHint.classList.remove(
                        'field-error'
                    );
                }


                const imageUrl =
                    URL.createObjectURL(
                        file
                    );


                const image =
                    document.createElement(
                        'img'
                    );


                image.src =
                    imageUrl;


                image.alt =
                    'Prévia da nova capa';


                image.onload =
                    () => {

                        URL.revokeObjectURL(
                            imageUrl
                        );

                    };


                coverPreview.replaceChildren(
                    image
                );

            }
        );
    }


    // =====================================================
    // PROGRESSO DA LEITURA
    // =====================================================

    const syncProgressFields = () => {

        if (
            !statusSelect ||
            !pagesInput ||
            !currentPageInput
        ) {
            return;
        }


        const total =
            Number(
                pagesInput.value || 0
            );


        const current =
            Number(
                currentPageInput.value || 0
            );


        // Se marcou como concluído
        if (
            statusSelect.value === 'read' &&
            total > 0
        ) {

            currentPageInput.value =
                String(total);

        }

        // Página atual maior que total
        else if (
            total > 0 &&
            current > total
        ) {

            currentPageInput.value =
                String(total);

        }
    };


    statusSelect?.addEventListener(
        'change',
        syncProgressFields
    );


    pagesInput?.addEventListener(
        'input',
        syncProgressFields
    );


    // =====================================================
    // FORMULÁRIOS
    // =====================================================

    document
        .querySelectorAll('form')
        .forEach((form) => {

            form.addEventListener(
                'submit',
                (event) => {

                    // Impede envio duplo
                    if (
                        form.dataset.submitting ===
                        'true'
                    ) {

                        event.preventDefault();

                        return;
                    }


                    // =================================================
                    // CONFIRMAÇÃO DE EXCLUSÃO
                    // =================================================

                    const deleteMessage =
                        form.dataset.confirmDelete;


                    if (
                        deleteMessage &&
                        !window.confirm(
                            deleteMessage
                        )
                    ) {

                        event.preventDefault();

                        return;
                    }


                    // =================================================
                    // INTERROMPE ENVIO NORMAL
                    // =================================================

                    event.preventDefault();


                    form.dataset.submitting =
                        'true';


                    const submitButton =
                        form.querySelector(
                            'button[type="submit"]'
                        );


                    const action =
                        form.getAttribute(
                            'action'
                        ) || '';


                    let loaderMessage =
                        'Processando sua solicitação...';


                    let buttonLabel =
                        'Processando...';


                    // =================================================
                    // FILTRO
                    // =================================================

                    if (
                        form.classList.contains(
                            'auth-form'
                        )
                    ) {

                        loaderMessage =
                            'Validando suas credenciais...';

                        buttonLabel =
                            'Entrando...';

                    }

                    else if (
                        form.classList.contains(
                            'filter-grid'
                        )
                    ) {

                        loaderMessage =
                            'Aplicando filtros ao acervo...';

                        buttonLabel =
                            'Filtrando...';

                    }


                    // =================================================
                    // CRIAR / EDITAR LIVRO
                    // =================================================

                    else if (
                        form.classList.contains(
                            'book-form'
                        )
                    ) {

                        loaderMessage =
                            'Salvando as informações do livro...';

                        buttonLabel =
                            'Salvando...';

                    }


                    // =================================================
                    // AVALIAÇÃO
                    // =================================================

                    else if (
                        form.classList.contains(
                            'rating-form'
                        )
                    ) {

                        loaderMessage =
                            'Salvando sua avaliação...';

                        buttonLabel =
                            'Salvando...';

                    }


                    // =================================================
                    // FAVORITOS
                    // =================================================

                    else if (
                        action.includes(
                            '/favorite'
                        )
                    ) {

                        loaderMessage =
                            'Atualizando favoritos...';

                        buttonLabel =
                            'Atualizando...';

                    }


                    // =================================================
                    // EXCLUSÃO
                    // =================================================

                    else if (
                        form.querySelector(
                            'input[name="_method"][value="DELETE"]'
                        )
                    ) {

                        loaderMessage =
                            'Excluindo o livro...';

                        buttonLabel =
                            'Excluindo...';

                    }


                    // =================================================
                    // ATIVA LOADING
                    // =================================================

                    setButtonLoading(
                        submitButton,
                        buttonLabel
                    );


                    showLoader(
                        loaderMessage
                    );


                    // =================================================
                    // AGUARDA 2 SEGUNDOS
                    // =================================================

                    setTimeout(
                        () => {

                            /*
                             * form.submit() é usado de propósito.
                             *
                             * Não usamos requestSubmit(),
                             * pois ele dispararia o evento
                             * submit novamente.
                             */

                            form.submit();

                        },

                        LOADING_DELAY
                    );

                }
            );

        });


    // =====================================================
    // LINKS COM LOADING
    // =====================================================

    document
        .querySelectorAll(
            '[data-loading-link]'
        )
        .forEach((link) => {

            link.addEventListener(
                'click',
                (event) => {

                    // Não interfere em Ctrl + clique,
                    // nova aba, etc.
                    if (
                        event.ctrlKey ||
                        event.metaKey ||
                        event.shiftKey ||
                        event.altKey ||
                        link.target === '_blank'
                    ) {

                        return;
                    }


                    event.preventDefault();


                    const destination =
                        link.href;


                    showLoader(

                        link.dataset.loadingLink ||
                        'Carregando...'

                    );


                    // =================================================
                    // AGUARDA 2 SEGUNDOS
                    // =================================================

                    setTimeout(
                        () => {

                            window.location.href =
                                destination;

                        },

                        LOADING_DELAY
                    );

                }
            );

        });


    // =====================================================
    // LOGIN INTERATIVO
    // =====================================================

    if (
        passwordInput &&
        passwordToggle
    ) {

        passwordToggle.addEventListener(
            'click',
            () => {

                const showing =
                    passwordInput.type === 'text';

                passwordInput.type =
                    showing ? 'password' : 'text';

                passwordToggle.classList.toggle(
                    'is-showing',
                    !showing
                );

                passwordToggle.setAttribute(
                    'aria-label',
                    showing
                        ? 'Mostrar senha'
                        : 'Ocultar senha'
                );

                passwordInput.focus();

            }
        );


        const syncCapsLock = (event) => {

            if (!capsLockHint) {
                return;
            }

            const active =
                event.getModifierState &&
                event.getModifierState('CapsLock');

            capsLockHint.hidden =
                !active;

        };


        passwordInput.addEventListener(
            'keydown',
            syncCapsLock
        );


        passwordInput.addEventListener(
            'keyup',
            syncCapsLock
        );


        passwordInput.addEventListener(
            'blur',
            () => {

                if (capsLockHint) {
                    capsLockHint.hidden = true;
                }

            }
        );
    }


    // =====================================================
    // FLASH MESSAGES DO LARAVEL
    // =====================================================

    const flash =
        window.bookListFlash || {};


    if (flash.success) {

        showToast(
            'success',
            'Tudo certo',
            flash.success
        );

    }


    if (flash.error) {

        showToast(
            'error',
            'Não foi possível concluir',
            flash.error
        );

    }


    if (flash.warning) {

        showToast(
            'warning',
            'Atenção',
            flash.warning
        );

    }


    if (flash.info) {

        showToast(
            'info',
            'Informação',
            flash.info
        );

    }


    // =====================================================
    // ERROS DE VALIDAÇÃO DO LARAVEL
    // =====================================================

    if (
        Array.isArray(
            flash.errors
        ) &&
        flash.errors.length
    ) {

        const message =
            flash.errors.length === 1

                ? flash.errors[0]

                : flash.errors
                    .slice(0, 3)
                    .join(' • ');


        showToast(
            'error',
            'Revise os campos',
            message
        );

    }


    // =====================================================
    // VOLTAR PELO NAVEGADOR
    // =====================================================

    window.addEventListener(
        'pageshow',
        () => {

            hideLoader();

        }
    );

});