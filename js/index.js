window.addEventListener("scroll", function () {
    const navbar = document.getElementById("mainNavbar");
    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const nav   = document.getElementById("mainNavbar");
    let lastY   = window.scrollY;
    const OFF   = 100;             // px to start watching
    const THR   = 10;              // px delta to trigger hide/show

    window.addEventListener("scroll", () => {
        const currentY = window.scrollY;
        const delta    = currentY - lastY;

        // ignore micro‑scrolls
        if (Math.abs(delta) < THR) return;

        if (currentY > OFF && delta > 0) {
            // scrolling DOWN
            nav.classList.add("navbar-hidden");
        } else {
            // scrolling UP or near top
            nav.classList.remove("navbar-hidden");
        }
        lastY = currentY;
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const nav = document.querySelector("nav");
    const hero = document.querySelector(".hero-section");
    if (nav && hero) {
        hero.style.marginTop = nav.offsetHeight + "px";
    }
});

// Active link highlighting in the navbar
document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

    navLinks.forEach(link => {
        const linkPath = link.getAttribute("href");
        if (linkPath === currentPath || (linkPath === "index.html" && currentPath === "")) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });
});


// Collapse navbar when a nav link is clicked (for mobile view)
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.navbar-nav .nav-link').forEach(function (navLink) {
        navLink.addEventListener('click', function () {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            
            // Only collapse if the navbar is currently expanded (showing)
            if (navbarCollapse.classList.contains('show')) {
                new bootstrap.Collapse(navbarCollapse).hide();
            }
        });
    });
});

// Generate bubbles on the page
const bubblesContainer = document.querySelector('.bubbles');
const colors = [
    'rgba(255, 255, 255, 0.3)',
    'rgba(173, 216, 230, 0.3)',
    'rgba(255, 182, 193, 0.3)',
    'rgba(144, 238, 144, 0.3)',
    'rgba(255, 255, 0, 0.3)',
    'rgba(255, 165, 0, 0.3)',
    'rgba(221, 160, 221, 0.3)'
];
for (let i = 0; i < 20; i++) {
    const bubble = document.createElement('div');
    bubble.classList.add('bubble');
    // Random color
    const color = colors[Math.floor(Math.random() * colors.length)];
    bubble.style.backgroundColor = color;
    // Random animation delay and duration
    bubble.style.left = `${Math.random() * 100}%`;
    bubble.style.animationDelay = `${Math.random() * 5}s`;
    bubble.style.animationDuration = `${4 + Math.random() * 4}s`;
    // Size: 1 in 5 bubbles is extra large
    let size;
    if (Math.random() < 0.2) {
        size = 100 + Math.random() * 50;  // Extra large: 100px to 150px
    } else {
        size = 20 + Math.random() * 30;   // Normal: 20px to 50px
    }
    bubble.style.width = `${size}px`;
    bubble.style.height = `${size}px`;
    bubblesContainer.appendChild(bubble);
}

// Form validation and submission
(() => {
    'use strict';
    const form = document.getElementById('contactForm');
    
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();
            sendEmail();
        }
        form.classList.add('was-validated');
    });
})();

// WhatsApp Message Logic
function sendWhatsApp() {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const subject = document.getElementById("subject").value.trim();
    const message = document.getElementById("message").value.trim();
    
    if (!name || !email || !subject || !message) {
        alert("Please fill out the form before sending via WhatsApp.");
        return;
    }
    
    const whatsappNumber = "233246490036";
    const text = `Name: ${name}%0AEmail: ${email}%0ASubject: ${subject}%0AMessage: ${message}`;
    const url = `https://wa.me/${whatsappNumber}?text=${text}`;
    window.open(url, "_blank");
}