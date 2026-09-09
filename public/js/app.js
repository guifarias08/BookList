document.addEventListener('DOMContentLoaded', function () {

    const html =
        document.documentElement;

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


    function updateThemeButton() {

        if (!themeToggle) {
            return;
        }

        const dark =
            html.classList.contains('dark');

        themeToggle.textContent =
            dark ? '☀' : '🌙';

    }


    if (themeToggle) {

        updateThemeButton();


        themeToggle.addEventListener(
            'click',
            function () {

                html.classList.toggle('dark');

                const dark =
                    html.classList.contains('dark');

                localStorage.setItem(
                    'booklist-theme',
                    dark ? 'dark' : 'light'
                );

                updateThemeButton();

            }
        );

    }


    if (menuButton && mainNav) {

        menuButton.addEventListener(
            'click',
            function () {

                mainNav.classList.toggle('open');

                menuButton.textContent =
                    mainNav.classList.contains('open')
                        ? '✕'
                        : '☰';

            }
        );

    }


    if (coverInput && coverPreview) {

        coverInput.addEventListener(
            'change',
            function () {

                const file =
                    coverInput.files[0];

                if (!file) {
                    return;
                }

                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        coverPreview.innerHTML = `
                            <img
                                src="${event.target.result}"
                                alt="Prévia da capa"
                            >
                        `;

                    };


                reader.readAsDataURL(file);

            }
        );

    }

});