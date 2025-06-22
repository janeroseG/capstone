const currentURL = window.location.href; 
 
const p = document.createElement('p'); 
p.textContent = `Current URL: ${currentURL}`; 
document.body.appendChild(p);
