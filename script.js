// script.js

// Function to toggle mobile menu
function toggleMobileMenu() {
    const navLinks = document.getElementById('navLinks');
    navLinks.classList.toggle('active');
}

// Shrink navigation bar on scroll
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('nav');
    if (window.scrollY > 50) { // Add 'scrolled' class after scrolling down 50px
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Close mobile menu when a link is clicked (for better UX)
document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        const navLinks = document.getElementById('navLinks');
        if (navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
        }
    });
});

// Animation on scroll
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1 // Trigger when 10% of the element is visible
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                observer.unobserve(entry.target); // Unobserve once animated
            }
        });
    }, observerOptions);

    document.querySelectorAll('.animate-on-scroll').forEach(element => {
        observer.observe(element);
    });
});

// Display form submission messages
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const formMessages = document.getElementById('form-messages');

    if (formMessages) {
        if (status === 'success') {
            formMessages.textContent = 'Your message has been sent successfully!';
            formMessages.style.color = '#4CAF50'; // Green color for success
            // Clear URL parameter after displaying message to prevent re-showing on refresh
            history.replaceState({}, document.title, window.location.pathname);
        } else if (status === 'error') {
            formMessages.textContent = 'There was an error sending your message. Please try again.';
            formMessages.style.color = '#f44336'; // Red color for error
            // Clear URL parameter
            history.replaceState({}, document.title, window.location.pathname);
        }
    }
});
