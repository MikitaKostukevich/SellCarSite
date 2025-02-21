document.addEventListener("DOMContentLoaded", () => {
    const newsCards = document.querySelectorAll(".news-card");
    newsCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add("fade-in");
        }, index * 200);
    });
});
