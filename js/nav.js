function toggleMenu () {  
    const navbar = document.querySelector("header");
    const burger = document.querySelector(".burger");
    burger.addEventListener("click", () => {    
      navbar.classList.toggle("show-nav");
    });    
  }
  toggleMenu();