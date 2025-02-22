document.addEventListener("DOMContentLoaded", function () {
    const uploadArea = document.getElementById("upload-area");
    const imageInput = document.getElementById("image-input");
    const previewImage = document.getElementById("preview-image");

    uploadArea.addEventListener("click", () => {
        imageInput.click();
    });

    imageInput.addEventListener("change", function () {
        const file = this.files[0];
        showPreview(file);
    });

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
        imageInput.files = e.dataTransfer.files;
        showPreview(file);
    });

    function showPreview(file) {
        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                previewImage.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }
});
