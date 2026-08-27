//
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
    | BUSCA DE LIVROS
    |--------------------------------------------------------------------------
    */

    const searchInput = document.getElementById("bookSearch");
    const genreFilter = document.getElementById("genreFilter");
    const searchButton = document.getElementById("searchButton");
    const resultCount = document.getElementById("resultCount");

    const rows = Array.from(
        document.querySelectorAll(".book-row")
    );


    function filterBooks() {

        if (!searchInput || !genreFilter) {
            return;
        }

        const search = searchInput.value
            .toLowerCase()
            .trim();

        const genre = genreFilter.value
            .toLowerCase();


        let visible = 0;


        rows.forEach(row => {

            const title =
                row.dataset.title || "";

            const author =
                row.dataset.author || "";

            const rowGenre =
                row.dataset.genre || "";


            const matchesSearch =
                title.includes(search) ||
                author.includes(search);


            const matchesGenre =
                !genre ||
                rowGenre === genre;


            const visibleRow =
                matchesSearch &&
                matchesGenre;


            if (visibleRow) {

                row.style.display = "";
                visible++;

                row.animate(
                    [
                        {
                            opacity: 0.5,
                            transform: "translateY(3px)"
                        },
                        {
                            opacity: 1,
                            transform: "translateY(0)"
                        }
                    ],
                    {
                        duration: 180,
                        easing: "ease-out"
                    }
                );

            } else {

                row.style.display = "none";

            }

        });


        if (resultCount) {

            resultCount.textContent =
                `${visible} ${
                    visible === 1
                        ? "resultado"
                        : "resultados"
                }`;

        }

    }


    if (searchInput) {

        searchInput.addEventListener(
            "input",
            filterBooks
        );

    }


    if (genreFilter) {

        genreFilter.addEventListener(
            "change",
            filterBooks
        );

    }


    if (searchButton) {

        searchButton.addEventListener(
            "click",
            filterBooks
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MODAL DE EXCLUSÃO
    |--------------------------------------------------------------------------
    */

    const deleteModal =
        document.getElementById("deleteModal");

    const cancelDelete =
        document.getElementById("cancelDelete");

    const confirmDelete =
        document.getElementById("confirmDelete");

    let formToDelete = null;


    document
        .querySelectorAll(".delete-form")
        .forEach(form => {

            form.addEventListener("submit", event => {

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

        confirmDelete.addEventListener(
            "click",
            () => {

                if (formToDelete) {

                    formToDelete.submit();

                }

            }
        );

    }


    if (deleteModal) {

        deleteModal.addEventListener(
            "click",
            event => {

                if (
                    event.target === deleteModal
                ) {

                    closeDeleteModal();

                }

            }
        );

    }


    document.addEventListener(
        "keydown",
        event => {

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
    document.addEventListener('DOMContentLoaded', () => {

    const ratingInput = document.getElementById('ratingInput');
    const rating = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');

    if (!ratingInput || !rating) {
        return;
    }

    const stars = ratingInput.querySelectorAll('.star');

    function updateStars(value) {

        stars.forEach(star => {

            const starValue = Number(star.dataset.rating);

            if (starValue <= value) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }

        });

        if (value > 0) {
            ratingText.textContent = `${value}/5 estrelas`;
        } else {
            ratingText.textContent = 'Selecione uma nota';
        }
    }

    stars.forEach(star => {

        star.addEventListener('click', () => {

            const value = Number(star.dataset.rating);

            rating.value = value;

            updateStars(value);

        });

        star.addEventListener('mouseenter', () => {

            const value = Number(star.dataset.rating);

            updateStars(value);

        });

    });

    ratingInput.addEventListener('mouseleave', () => {

        updateStars(Number(rating.value) || 0);

    });

    updateStars(Number(rating.value) || 0);
});
}