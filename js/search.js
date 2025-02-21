document.querySelector("#search-form").addEventListener("submit", function (e) {
    e.preventDefault();
    
    const query = document.querySelector("#search-input").value;
    const resultContainer = document.querySelector("#search-results");
    
    resultContainer.innerHTML = `<div class="loader"></div>`; // Анимация загрузки

    fetch(`search.php?query=${query}`)
        .then(response => response.text())
        .then(data => {
            resultContainer.innerHTML = data;
        })
        .catch(error => {
            resultContainer.innerHTML = `<p style="color:red;">Ошибка загрузки</p>`;
            console.error(error);
        });
});
