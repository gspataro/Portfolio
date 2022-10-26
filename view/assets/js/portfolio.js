document.addEventListener("DOMContentLoaded", () => {
    const categories = document.querySelectorAll("[data-show]");

    categories.forEach((anchor) => {
        anchor.addEventListener("click", () => {
            document.querySelectorAll(".active[data-show]").forEach((e) => {
                e.classList.remove("active");
            });

            document.querySelectorAll("[data-category]").forEach((item) => {
                item.style.display =
                    (anchor.dataset.show == "all" || item.dataset.category == anchor.dataset.show)
                    ? ""
                    : "none";
            });


            anchor.classList.add("active");
        });
    });
});
