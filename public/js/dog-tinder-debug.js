// Dog Tinder Debug Script

// Function to intercept fetch requests and log them
const originalFetch = window.fetch;
window.fetch = function (url, options) {
    console.log('Fetch Request:', { url, options });

    // Log the form data if it exists
    if (options && options.body instanceof FormData) {
        console.log('Form Data:');
        for (let pair of options.body.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
    }

    return originalFetch.apply(this, arguments)
        .then(response => {
            // Clone the response so we can read it twice
            const clone = response.clone();

            // Log the response status
            console.log('Response Status:', response.status);

            // Try to parse and log the JSON response
            clone.json().then(data => {
                console.log('Response Data:', data);
            }).catch(err => {
                console.log('Response is not JSON');
            });

            return response;
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            throw error;
        });
};

// Add event listeners to the like/dislike buttons
document.addEventListener('DOMContentLoaded', function () {
    console.log('Dog Tinder Debug Script loaded');

    // Find all like and dislike buttons
    const likeButtons = document.querySelectorAll('.like-btn');
    const dislikeButtons = document.querySelectorAll('.dislike-btn');

    console.log('Like buttons found:', likeButtons.length);
    console.log('Dislike buttons found:', dislikeButtons.length);

    // Add click event listeners to log when buttons are clicked
    likeButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            console.log('Like button clicked', event);
        });
    });

    dislikeButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            console.log('Dislike button clicked', event);
        });
    });
});

// Check if the swipeDog function exists
console.log('swipeDog function exists:', typeof swipeDog === 'function');

// Override the swipeDog function to add debugging
if (typeof window.originalSwipeDog === 'undefined' && typeof window.swipeDog === 'function') {
    window.originalSwipeDog = window.swipeDog;
    window.swipeDog = function (dogId, action) {
        console.log('swipeDog called with:', { dogId, action });
        return window.originalSwipeDog(dogId, action);
    };
}