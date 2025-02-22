document.addEventListener("DOMContentLoaded", function () {
    const uploadArea = document.getElementById("upload-area");
    const imageInput = document.getElementById("image-input");
    const previewImage = document.getElementById("preview-image");

    // При перетаскивании изображения
    uploadArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        uploadArea.classList.add("dragging");
    });

    uploadArea.addEventListener("dragleave", () => {
        uploadArea.classList.remove("dragging");
    });

    uploadArea.addEventListener("drop", (e) => {
        e.preventDefault();
        uploadArea.classList.remove("dragging");

        if (e.dataTransfer.files.length > 0) {
            imageInput.files = e.dataTransfer.files;
            previewFile(imageInput.files[0]);
        }
    });

    // При выборе файла вручную
    imageInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            previewFile(this.files[0]);
        }
    });

    function previewFile(file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
});
