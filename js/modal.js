let modal = document.querySelector("#myModal");
let btn = document.querySelector(".myBtn");
let spn = document.querySelector(".close");

btn.addEventListener("click", function () {
    modal.style.display = "block";
});

spn.addEventListener("click", function () {
    modal.style.display = "none";
});

window.addEventListener("click", function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
});