document.getElementById('toggle-desc')?.addEventListener('click', function() {
    const shortDesc = document.getElementById('desc-short');
    const fullDesc = document.getElementById('desc-full');

    if (fullDesc.classList.contains('d-none')) {
        shortDesc.classList.add('d-none');
        fullDesc.classList.remove('d-none');
        shortDesc.classList.remove('fade-bottom'); 
        this.textContent = "Show less";
    } else {
        fullDesc.classList.add('d-none');
        shortDesc.classList.remove('d-none');
        shortDesc.classList.add('fade-bottom');
        this.textContent = "Show more";
    }
});

document.querySelectorAll('.review-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
        const parent = btn.closest('.review-content');
        const shortText = parent.querySelector('.short-text');
        const fullText = parent.querySelector('.full-text');

        const label = btn.querySelector('.label-text');
        const arrow = btn.querySelector('.arrow');

        if (fullText.classList.contains('d-none')) {
            fullText.classList.remove('d-none');
            shortText.classList.add('d-none');
            shortText.classList.remove('fade-bottom');

            label.textContent = "Show less";
            arrow.style.transform = "rotate(180deg)";
        } else {
            fullText.classList.add('d-none');
            shortText.classList.remove('d-none');
            shortText.classList.add('fade-bottom');

            label.textContent = "Show more";
            arrow.style.transform = "rotate(0deg)";
        }
    });
});

let rating = 0;

document.querySelectorAll('.star-input').forEach(star => {
    star.addEventListener('mouseover', () => {
        let val = star.dataset.value;
        fillStars(val);
    });

    star.addEventListener('mouseout', () => {
        fillStars(rating);
    });

    star.addEventListener('click', () => {
        rating = star.dataset.value;
        document.getElementById('rating-input').value = rating;
        document.getElementById('rating-text').textContent =
            rating + " star" + (rating > 1 ? "s" : "");
        fillStars(rating);
    });
});

function fillStars(value) {
    document.querySelectorAll('.star-input').forEach(star => {
        let starVal = parseInt(star.dataset.value);

        if (starVal <= value) {
            star.classList.add("selected");
            star.classList.remove("bi-star");
            star.classList.add("bi-star-fill");
        } else {
            star.classList.remove("selected");
            star.classList.add("bi-star");
            star.classList.remove("bi-star-fill");
        }
    });
}
