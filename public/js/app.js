document.addEventListener('DOMContentLoaded', () => {
    const html = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');
    const menuButton = document.getElementById('menuButton');
    const mainNav = document.getElementById('mainNav');
    const coverInput = document.getElementById('cover');
    const coverPreview = document.getElementById('coverPreview');
    const coverHint = document.getElementById('coverHint');
    const statusSelect = document.getElementById('status');
    const pagesInput = document.getElementById('pages');
    const currentPageInput = document.getElementById('current_page');

    const syncThemeButton = () => {
        if (!themeToggle) return;

        const dark = html.classList.contains('dark');
        themeToggle.setAttribute('aria-pressed', String(dark));
        themeToggle.setAttribute('aria-label', dark ? 'Ativar tema claro' : 'Ativar tema escuro');
        themeToggle.title = dark ? 'Tema claro' : 'Tema escuro';
    };

    const closeMenu = () => {
        if (!menuButton || !mainNav) return;

        mainNav.classList.remove('open');
        menuButton.setAttribute('aria-expanded', 'false');
        menuButton.setAttribute('aria-label', 'Abrir menu');
    };

    if (themeToggle) {
        syncThemeButton();

        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');

            const dark = html.classList.contains('dark');
            localStorage.setItem('booklist-theme', dark ? 'dark' : 'light');

            syncThemeButton();
        });
    }

    if (menuButton && mainNav) {
        menuButton.addEventListener('click', () => {
            const open = mainNav.classList.toggle('open');

            menuButton.setAttribute('aria-expanded', String(open));
            menuButton.setAttribute('aria-label', open ? 'Fechar menu' : 'Abrir menu');
        });

        mainNav.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeMenu();
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 700) closeMenu();
        });
    }

    if (coverInput && coverPreview) {
        coverInput.addEventListener('change', () => {
            const file = coverInput.files?.[0];

            if (!file) return;

            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 2 * 1024 * 1024;

            if (!validTypes.includes(file.type) || file.size > maxSize) {
                coverInput.value = '';

                if (coverHint) {
                    coverHint.textContent = file.size > maxSize
                        ? 'A imagem precisa ter no máximo 2 MB.'
                        : 'Use uma imagem JPG, PNG ou WEBP.';
                    coverHint.classList.add('field-error');
                }

                return;
            }

            if (coverHint) {
                coverHint.textContent = coverHint.dataset.defaultText || '';
                coverHint.classList.remove('field-error');
            }

            const imageUrl = URL.createObjectURL(file);
            const image = document.createElement('img');

            image.src = imageUrl;
            image.alt = 'Prévia da nova capa';
            image.onload = () => URL.revokeObjectURL(imageUrl);

            coverPreview.replaceChildren(image);
        });
    }

    const syncProgressFields = () => {
        if (!statusSelect || !pagesInput || !currentPageInput) return;

        const total = Number(pagesInput.value || 0);
        const current = Number(currentPageInput.value || 0);

        if (statusSelect.value === 'read' && total > 0) {
            currentPageInput.value = String(total);
        } else if (total > 0 && current > total) {
            currentPageInput.value = String(total);
        }
    };

    statusSelect?.addEventListener('change', syncProgressFields);
    pagesInput?.addEventListener('input', syncProgressFields);

    document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const message = form.dataset.confirmDelete || 'Confirmar exclusão?';

            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });
});