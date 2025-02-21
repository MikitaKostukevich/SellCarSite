const dropArea = document.querySelector(".drop-area");

dropArea.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropArea.classList.add("drag-over");
});

dropArea.addEventListener("dragleave", () => {
    dropArea.classList.remove("drag-over");
});

dropArea.addEventListener("drop", (e) => {
    e.preventDefault();
    dropArea.classList.remove("drag-over");

    const files = e.dataTransfer.files;
    const fileList = document.querySelector("#file-list");
    
    fileList.innerHTML = "";
    for (const file of files) {
        fileList.innerHTML += `<p>${file.name}</p>`;
    }
});
