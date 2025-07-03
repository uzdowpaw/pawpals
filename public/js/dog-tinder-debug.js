// Debug script for dog-tinder.js
console.log('Dog Tinder Debug Script Loaded - Enhanced Version');

// Check DOM state immediately
if (document.readyState === 'loading') {
    console.log('Document is still loading...');
} else {
    console.log('Document is already loaded');
    debugCheckButtons();
}

// Function to check and debug button elements
function debugCheckButtons() {
    // Log all like/dislike buttons found
    const likeButtons = document.querySelectorAll('.like-btn');
    const dislikeButtons = document.querySelectorAll('.dislike-btn');
    
    console.log(`Found ${likeButtons.length} like buttons`);
    console.log(`Found ${dislikeButtons.length} dislike buttons`);
    
    // Detailed inspection of buttons
    if (likeButtons.length > 0) {
        console.log('First like button details:');
        const firstLikeBtn = likeButtons[0];
        console.log('- HTML:', firstLikeBtn.outerHTML);
        console.log('- data-dog-id:', firstLikeBtn.getAttribute('data-dog-id'));
        console.log('- Computed styles:', window.getComputedStyle(firstLikeBtn));
        console.log('- Is visible:', firstLikeBtn.offsetParent !== null);
        console.log('- Event listeners cannot be inspected directly');
        
        // Add a test click handler
        firstLikeBtn.addEventListener('click', function(e) {
            console.log('TEST HANDLER: Like button clicked via direct test handler');
        });
    }
    
    // Check parent elements for potential event blocking
    if (likeButtons.length > 0) {
        let element = likeButtons[0];
        let path = [];
        while (element && element !== document.body) {
            path.push({
                tag: element.tagName,
                id: element.id,
                classes: Array.from(element.classList),
                position: window.getComputedStyle(element).position,
                zIndex: window.getComputedStyle(element).zIndex
            });
            element = element.parentElement;
        }
        console.log('DOM path to like button:', path);
    }
}

// Add event listeners to monitor button clicks
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');
    debugCheckButtons();
    
    // Add a global click handler to debug all clicks
    document.addEventListener('click', function(event) {
        console.log('Global click detected on:', event.target);
        console.log('Event path:', event.composedPath().map(el => el.tagName || el.nodeName));
    }, true); // Use capture phase to see all clicks
    
    // Monitor click events
    document.body.addEventListener('click', function(event) {
        console.log('Body click detected on:', event.target);
        
        if (event.target.closest('.like-btn')) {
            const likeBtn = event.target.closest('.like-btn');
            const dogId = likeBtn.getAttribute('data-dog-id');
            console.log(`Like button clicked for dog ID: ${dogId}`);
            console.log('Button element:', likeBtn);
            console.log('data-dog-id attribute:', likeBtn.getAttribute('data-dog-id'));
            console.log('dataset.dogId:', likeBtn.dataset.dogId);
        } else if (event.target.closest('.dislike-btn')) {
            const dislikeBtn = event.target.closest('.dislike-btn');
            const dogId = dislikeBtn.getAttribute('data-dog-id');
            console.log(`Dislike button clicked for dog ID: ${dogId}`);
            console.log('Button element:', dislikeBtn);
            console.log('data-dog-id attribute:', dislikeBtn.getAttribute('data-dog-id'));
            console.log('dataset.dogId:', dislikeBtn.dataset.dogId);
        }
    });
    
    // Add direct handlers as a test
    document.querySelectorAll('.like-btn, .dislike-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            console.log('Direct debug handler fired for', this.className);
            // Don't prevent default or stop propagation here - just log
        });
    });
});