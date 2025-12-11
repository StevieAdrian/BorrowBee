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

document.querySelectorAll('.follow-form').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = form.querySelector('.follow-btn');

        let response = await fetch(form.action, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": form.querySelector("input[name=_token]").value,
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({})
        });

        if (!response.ok) {
            // console.log("debug err ajx: ", await response.text());
            return;
        }

        let data = await response.json();

        if (data.status === "followed") {
            btn.textContent = "Unfollow";
        } else if (data.status === "unfollowed") {
            btn.textContent = "Follow";
        }

        const stat = form.closest('.author-box').querySelector('.stats');

        if (stat && data.followers_count !== undefined) {
            // console.log("tes masuk");
            let books = stat.textContent.split("·")[0].trim();
            stat.textContent = `${books} · ${data.followers_count} followers`;
        } 
    });
});


document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".edit-review-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const reviewBox = btn.closest(".review-box");

            reviewBox.querySelector(".review-text.short-text").classList.add("d-none");
            reviewBox.querySelector(".review-text.full-text").classList.add("d-none");

            reviewBox.querySelector(".edit-review-form").classList.remove("d-none");
        });
    });

    document.querySelectorAll(".cancel-edit").forEach(btn => {
        btn.addEventListener("click", () => {
            const reviewBox = btn.closest(".review-box");

            reviewBox.querySelector(".review-text.short-text").classList.remove("d-none");
            reviewBox.querySelector(".edit-review-form").classList.add("d-none");
        });
    });

    document.querySelectorAll(".edit-review-form .star-input").forEach(star => {
        star.addEventListener("click", () => {
            const value = star.dataset.value;

            const form = star.closest(".edit-review-form");
            form.querySelector(".edit-rating-input").value = value;

            form.querySelectorAll(".star-input").forEach(s => {
                if (s.dataset.value <= value) s.classList.add("text-warning");
                else s.classList.remove("text-warning");
            });
        });
    });
});
