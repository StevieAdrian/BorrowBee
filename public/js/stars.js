const stars = document.querySelectorAll("#star-rating .star");
const ratingInput = document.getElementById("rating");

stars.forEach((star) => {
    star.addEventListener("click", () => {
        const value = star.getAttribute("data-value");
        ratingInput.value = value;

        stars.forEach((s) => s.classList.remove("filled"));
        for (let i = 0; i < value; i++) {
            stars[i].classList.add("filled");
        }
    });
});
