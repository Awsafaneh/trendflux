// script.js - أضف هذا الكود في نهاية الملف

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
