document.addEventListener("DOMContentLoaded", function () {
    const uploadArea = document.getElementById("upload-area");
    const imageInput = document.getElementById("image-input");
    const previewImage = document.getElementById("preview-image");

    // Открытие окна выбора файла при клике
    uploadArea.addEventListener("click", () => {
        imageInput.click();
    });

    // Обработка выбора файла
    imageInput.addEventListener("change", function () {
        const file = this.files[0];
        showPreview(file);
    });

    // Перетаскивание файла
    uploadArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        uploadArea.style.backgroundColor = "rgba(0, 123, 255, 0.1)";
    });

    uploadArea.addEventListener("dragleave", () => {
        uploadArea.style.backgroundColor = "transparent";
    });

    uploadArea.addEventListener("drop", (e) => {
        e.preventDefault();
        uploadArea.style.backgroundColor = "transparent";

        const file = e.dataTransfer.files[0];
        imageInput.files = e.dataTransfer.files; // Добавляем файл в input
        showPreview(file);
    });

    // Функция для отображения превью
    function showPreview(file) {
        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }
});
