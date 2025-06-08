const images = document.querySelectorAll(".gallery-img");
const modal = document.getElementById("imageModal");
const modalImg = document.getElementById("modalImg");
const closeBtn = document.querySelector(".close");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
let currentIndex = 0;

function openModal(index) {
    modal.style.display = "flex";
    modalImg.src = images[index].src;
    currentIndex = index;
}

images.forEach((img, index) => {
    img.addEventListener("click", () => openModal(index));
});

closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
});

prevBtn.addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    modalImg.src = images[currentIndex].src;
});

nextBtn.addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % images.length;
    modalImg.src = images[currentIndex].src;
});

console.log("JavaScript file is connected!");
