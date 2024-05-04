document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll("#review_star-rating .fa-star");
    const hiddenInput = document.querySelector("#review_star-rating input[type='hidden']");

    stars.forEach(function (star) {
        star.addEventListener("click", function () {
            const rating = parseInt(this.getAttribute("data-rating"));

            // クリックされた星の前までの全ての星に青色のスタイルを適用し、それ以降の星には灰色のスタイルを適用する
            stars.forEach(function (s, index) {
                if (index < rating) {
                    s.classList.remove("far");
                    s.classList.add("fas");
                    s.style.color = "blue";
                } else {
                    s.classList.remove("fas");
                    s.classList.add("far");
                    s.style.color = "gray";
                }
            });
            hiddenInput.value = rating;
        });
    });
});