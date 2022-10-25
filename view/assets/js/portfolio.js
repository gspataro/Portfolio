document.addEventListener("DOMContentLoaded", () => {
    const categories = document.querySelectorAll("[data-show]");

    categories.forEach((e) => {
        e.addEventListener("click", () => {
            document.querySelectorAll(".active[data-show]").forEach((e) => {
                e.classList.remove("active");
            });

            document.querySelectorAll("[data-category]").forEach((e) => {
                e.style.display = "none";
            });

            if (e.dataset.show == 'all') {
                document.querySelectorAll("[data-category]").forEach((e) => {
                    e.style.display = "";
                });
            } else {
                console.log(e.dataset.show);
                document.querySelectorAll("[data-category=" + e.dataset.show + "]").forEach((e) => {
                    e.style.display = "";
                });
            }

            e.classList.add("active");
        });
    });
});
