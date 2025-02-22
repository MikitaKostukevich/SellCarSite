document.addEventListener("DOMContentLoaded", function () {
    const newsDate = document.querySelector(".news-date");
    
    if (newsDate) {
        const dateString = newsDate.textContent.replace("Дата публикации: ", "");
        const date = new Date(dateString);
        
        const formattedDate = date.toLocaleDateString("ru-RU", {
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        });

        newsDate.textContent = `Опубликовано: ${formattedDate}`;
    }
});
