const output = document.querySelector(".upload output");
const input = document.querySelector(".upload input");
let imagesArray = [];

window.addEventListener('load', ()=>{
    input.value = "";
});

input.addEventListener("change", () => {
    const files = input.files;
    for (let i = 0; i < files.length; i++) {
        imagesArray.push(files[i]);
    }
    displayImages();
});

function displayImages() {
    let images = "";
    imagesArray.forEach((image, index) => {
        images += `<div class="image">
                <img src="${URL.createObjectURL(image)}" alt="image">
                <span onclick="deleteImage(${index})" class="delete"><i class="la la-close"></i></span>
              </div>`
    });
    output.innerHTML = images;
}

function deleteImage(index) {
    imagesArray.splice(index, 1);
    displayImages();
}


