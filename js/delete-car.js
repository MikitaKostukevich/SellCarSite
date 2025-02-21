document.querySelectorAll(".delete-btn").forEach((button) => {
    button.addEventListener("click", (e) => {
        e.preventDefault();
        const carCard = button.closest(".car-card");

        if (confirm("Вы уверены, что хотите удалить?")) {
            carCard.style.opacity = "0";
            setTimeout(() => carCard.remove(), 500);
        }
    });
});
