// Debug script for CSRF token handling
console.log('CSRF Debug Script Loaded');

document.addEventListener('DOMContentLoaded', function() {
    // Check if CSRF token meta tag exists
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (csrfToken) {
        console.log('CSRF token found:', csrfToken.getAttribute('content'));
    } else {
        console.error('CSRF token meta tag not found! This will cause AJAX requests to fail.');
    }
    
    // Monitor all fetch requests
    const originalFetch = window.fetch;
    window.fetch = function(url, options) {
        console.log('Fetch request intercepted:', { url, options });
        return originalFetch.apply(this, arguments)
            .then(response => {
                console.log('Fetch response:', response);
                return response;
            })
            .catch(error => {
                console.error('Fetch error:', error);
                throw error;
            });
    };
});