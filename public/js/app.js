document.addEventListener("DOMContentLoaded", () => {

    /*
    |--------------------------------------------------------------------------
    | MENU MOBILE
    |--------------------------------------------------------------------------
    */

    const menuButton = document.getElementById("mobileMenuButton");
    const navLinks = document.getElementById("navLinks");

    if (menuButton && navLinks) {
        menuButton.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });
    }


    /*
    |--------------------------------------------------------------------------
    | DARK MODE
    |--------------------------------------------------------------------------
    */

    const themeToggle = document.getElementById("themeToggle");

    const savedTheme = localStorage.getItem("booklist-theme");

    if (savedTheme === "dark") {
        document.body.classList.add("dark-theme");
    }

    updateThemeIcon();

    if (themeToggle) {
        themeToggle.addEventListener("click", () => {

            document.body.classList.toggle("dark-theme");

            const theme = document.body.classList.contains("dark-theme")
                ? "dark"
                : "light";

            localStorage.setItem("booklist-theme", theme);

            updateThemeIcon();
        });
    }

    function updateThemeIcon() {
        if (!themeToggle) {
            return;
        }

        themeToggle.textContent =
            document.body.classList.contains("dark-theme")
                ? "☀️"
                : "🌙";
    }


    /*
    |--------------------------------------------------------------------------
    | PRÉVIA DA CAPA
    |--------------------------------------------------------------------------
    */

    const coverInput = document.getElementById("cover");
    const coverPreview = document.getElementById("coverPreview");
    const coverPlaceholder = document.getElementById("coverPlaceholder");

    if (coverInput && coverPreview) {

        coverInput.addEventListener("change", (event) => {

            const file = event.target.files[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith("image/")) {
                alert("Selecione uma imagem válida.");
                coverInput.value = "";
                return;
            }

            const reader = new FileReader();

            reader.onload = (event) => {

                coverPreview.src = event.target.result;

                coverPreview.classList.remove("hidden");

                if (coverPlaceholder) {
                    coverPlaceholder.classList.add("hidden");
                }
            };

            reader.readAsDataURL(file);
        });
    }


    /*
    |--------------------------------------------------------------------------
    | GRID / LISTA
    |--------------------------------------------------------------------------
    */

    const booksContainer = document.getElementById("booksContainer");

    const gridViewButton = document.getElementById("gridViewButton");
    const listViewButton = document.getElementById("listViewButton");

    const savedView =
        localStorage.getItem("booklist-view") || "grid";

    setBookView(savedView);

    if (gridViewButton) {
        gridViewButton.addEventListener("click", () => {
            setBookView("grid");
        });
    }

    if (listViewButton) {
        listViewButton.addEventListener("click", () => {
            setBookView("list");
        });
    }

    function setBookView(view) {

        if (!booksContainer) {
            return;
        }

        if (view === "list") {

            booksContainer.classList.remove("books-grid");
            booksContainer.classList.add("books-list");

            gridViewButton?.classList.remove("active");
            listViewButton?.classList.add("active");

        } else {

            booksContainer.classList.remove("books-list");
            booksContainer.classList.add("books-grid");

            listViewButton?.classList.remove("active");
            gridViewButton?.classList.add("active");
        }

        localStorage.setItem("booklist-view", view);
    }


    /*
    |--------------------------------------------------------------------------
    | MODAL DE EXCLUSÃO
    |--------------------------------------------------------------------------
    */

    const deleteModal = document.getElementById("deleteModal");
    const cancelDelete = document.getElementById("cancelDelete");
    const confirmDelete = document.getElementById("confirmDelete");

    let formToDelete = null;

    document
        .querySelectorAll(".delete-form")
        .forEach((form) => {

            form.addEventListener("submit", (event) => {

                if (!deleteModal) {
                    return;
                }

                event.preventDefault();

                formToDelete = form;

                deleteModal.classList.add("active");

                deleteModal.setAttribute(
                    "aria-hidden",
                    "false"
                );
            });
        });


    function closeDeleteModal() {

        if (!deleteModal) {
            return;
        }

        deleteModal.classList.remove("active");

        deleteModal.setAttribute(
            "aria-hidden",
            "true"
        );

        formToDelete = null;
    }


    if (cancelDelete) {
        cancelDelete.addEventListener(
            "click",
            closeDeleteModal
        );
    }


    if (confirmDelete) {

        confirmDelete.addEventListener("click", () => {

            if (formToDelete) {
                formToDelete.submit();
            }

        });
    }


    if (deleteModal) {

        deleteModal.addEventListener(
            "click",
            (event) => {

                if (event.target === deleteModal) {
                    closeDeleteModal();
                }

            }
        );
    }


    document.addEventListener(
        "keydown",
        (event) => {

            if (
                event.key === "Escape" &&
                deleteModal?.classList.contains("active")
            ) {
                closeDeleteModal();
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | TOAST
    |--------------------------------------------------------------------------
    */

    const toast =
        document.getElementById("successToast");

    if (toast) {

        setTimeout(() => {
            closeToast();
        }, 4500);

    }


    /*
    |--------------------------------------------------------------------------
    | ESTRELAS DO FORMULÁRIO
    |--------------------------------------------------------------------------
    */

    const ratingInput =
        document.getElementById("ratingInput");

    const rating =
        document.getElementById("rating");

    const ratingText =
        document.getElementById("ratingText");


    if (ratingInput && rating) {

        const stars =
            ratingInput.querySelectorAll(".star");


        function updateStars(value) {

            stars.forEach((star) => {

                const starValue =
                    Number(star.dataset.rating);

                if (starValue <= value) {

                    star.classList.add("active");

                } else {

                    star.classList.remove("active");

                }

            });


            if (ratingText) {

                ratingText.textContent =
                    value > 0
                        ? `${value}/5 estrelas`
                        : "Selecione uma nota";

            }

        }


        stars.forEach((star) => {

            star.addEventListener("click", () => {

                const value =
                    Number(star.dataset.rating);

                rating.value = value;

                updateStars(value);

            });


            star.addEventListener(
                "mouseenter",
                () => {

                    updateStars(
                        Number(star.dataset.rating)
                    );

                }
            );

        });


        ratingInput.addEventListener(
            "mouseleave",
            () => {

                updateStars(
                    Number(rating.value) || 0
                );

            }
        );


        updateStars(
            Number(rating.value) || 0
        );
    }

});


/*
|--------------------------------------------------------------------------
| FECHAR TOAST
|--------------------------------------------------------------------------
*/

function closeToast() {

    const toast =
        document.getElementById("successToast");

    if (!toast) {
        return;
    }

    toast.style.opacity = "0";

    toast.style.transform =
        "translateX(30px)";

    setTimeout(() => {
        toast.remove();
    }, 250);
}