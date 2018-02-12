
window.onload = function() {
    const photoInput = document.getElementById("photoInput");
    photoInput.addEventListener("change", readURL); //event listener for a file upload
    const photoPreview = document.getElementById("photoPreview");
    const submitBtn =  document.getElementById("submit");
    submitBtn.addEventListener("click", sendData);
    const nameInput = document.getElementById("nameInput");
    const commentInput = document.getElementById("commentInput");
    const openForm = document.getElementById("openForm");
    const top = document.getElementById("top");
    openForm.addEventListener("click", function() {
        openForm.style.display = "none";
    });
    top.addEventListener("click", function() {
        openForm.style.display = "block";
        
    });
}

function readURL() {
    if (this.files && this.files[0]) {
        photoPreview.innerHTML = "";
        const reader = new FileReader();
        reader.readAsDataURL(this.files[0]);

        // when reader has uploaded file, add it to the preview
        reader.onload = function(e) {
            const prevImg = new Image();
            prevImg.src = e.target.result;
            prevImg.id = "previewImg";

            prevImg.onload = function(e) {
                photoPreview.appendChild(prevImg);
            }
        }
    }
    else {
        photoPreview.innerHTML = '<i class="far fa-file-image"></i>'
    }
}

function errShow(elem) {
    elem.classList.add("error-init", "error-change");
    setTimeout(function() {
        elem.classList.remove("error-change", "error-init");
    }, 1000)
}

