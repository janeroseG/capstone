
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', () => {
   
    const newHeight = window.scrollY > 100 ? '50px' : '100px'; // Adjust the scroll position as needed


    navbar.style.height = newHeight;
});
