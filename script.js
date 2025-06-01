const langToggleBtn = document.getElementById('langToggle');
const htmlElement = document.documentElement;
let currentLang = localStorage.getItem('lang') || 'en'; // Default to English

// Function to update content based on language
function updateContent(lang) {
    document.querySelectorAll('[data-lang-en]').forEach(element => {
        if (lang === 'ar') {
            element.textContent = element.getAttribute('data-lang-ar');
        } else {
            element.textContent = element.getAttribute('data-lang-en');
        }
    });
    // Update title
    document.title = document.querySelector('title').getAttribute(`data-lang-${lang}`);
    // Update button text: if currentLang is 'en', show 'العربية', else show 'English'
    langToggleBtn.textContent = lang === 'en' ? 'العربية' : 'English';
    // Update document direction and lang attribute
    htmlElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
    htmlElement.setAttribute('lang', lang);
}

// Initial content load on page load for the specific page
updateContent(currentLang);

// Language toggle event listener
langToggleBtn.addEventListener('click', () => {
    currentLang = currentLang === 'en' ? 'ar' : 'en'; // Toggle language
    localStorage.setItem('lang', currentLang); // Save preference
    updateContent(currentLang); // Update content
});

// Function to toggle mobile menu for responsiveness
function toggleMobileMenu() {
    const navLinks = document.getElementById('navLinks');
    navLinks.classList.toggle('active');
}

// Function to handle scroll animations for elements with .animate-on-scroll
function triggerAnimations() {
    const elements = document.querySelectorAll('.animate-on-scroll');
    elements.forEach(el => {
        const rect = el.getBoundingClientRect();
        // Check if element is in viewport (partially visible)
        if (rect.top < window.innerHeight - 100 && rect.bottom > 0) { /* Added -100px buffer */
            el.classList.add('animated');
        } else {
            // Optional: remove animated class when out of view to re-animate on scroll back
            // This is generally not needed for multi-page sites as animations reset on page load
            // el.classList.remove('animated');
        }
    });
}

// Add scroll event listener for animations
window.addEventListener('scroll', triggerAnimations);

// Execute functions when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    triggerAnimations(); // Initial check for animations on page load
});
