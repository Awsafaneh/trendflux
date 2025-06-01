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

// Form submission handler (using Fetch API for AJAX submission)
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-form');
    const formMessages = document.getElementById('form-messages');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission (page reload)

            // Show loading message
            formMessages.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...'; // Changed to English
            formMessages.style.color = '#ffd700'; // Yellow/Gold for loading

            // Collect form data
            const formData = new FormData(this);

            // Send data using fetch API
            fetch('send_email.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) { // Check for HTTP errors (e.g., 404, 500)
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json(); // Parse JSON response
            })
            .then(data => {
                if (data.status === 'success') {
                    formMessages.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message;
                    formMessages.style.color = '#4CAF50'; // Green for success
                    contactForm.reset(); // Clear the form fields
                } else {
                    formMessages.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + data.message;
                    formMessages.style.color = '#f44336'; // Red for error
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error); // Log detailed error to console
                formMessages.innerHTML = '<i class="fas fa-exclamation-triangle"></i> An error occurred during submission. Please try again.'; // Changed to English
                formMessages.style.color = '#f44336';
            });
        });
    }
});
