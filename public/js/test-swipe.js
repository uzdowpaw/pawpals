// Alternative implementation for dog swipe functionality
console.log('Test Swipe Script Loaded');

// Check if jQuery is available (for debugging)
if (typeof jQuery !== 'undefined') {
    console.log('jQuery is available, version:', jQuery.fn.jquery);
} else {
    console.log('jQuery is NOT available');
}

// Check if the DOM is ready
if (document.readyState === 'loading') {
    console.log('Document is still loading...');
} else {
    console.log('Document is ready!');
    // Check for buttons immediately
    const likeButtons = document.querySelectorAll('.like-btn');
    const dislikeButtons = document.querySelectorAll('.dislike-btn');
    console.log('Immediate check - Like buttons:', likeButtons.length);
    console.log('Immediate check - Dislike buttons:', dislikeButtons.length);
}

document.addEventListener('DOMContentLoaded', function() {
    // Direct event listeners for like/dislike buttons
    const likeButtons = document.querySelectorAll('.like-btn');
    const dislikeButtons = document.querySelectorAll('.dislike-btn');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const dogId = this.getAttribute('data-dog-id');
            console.log(`Direct like button click handler for dog ID: ${dogId}`);
            handleSwipe(dogId, 'like', this);
        });
    });
    
    dislikeButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const dogId = this.getAttribute('data-dog-id');
            console.log(`Direct dislike button click handler for dog ID: ${dogId}`);
            handleSwipe(dogId, 'dislike', this);
        });
    });
    
    function handleSwipe(dogId, action, button) {
        console.log(`Test swipe handler called: ${action} for dog ${dogId}`);
        
        const card = document.getElementById(`dog-card-${dogId}`);
        if (!card) {
            console.error(`Dog card not found for ID: ${dogId}`);
            return;
        }
        
        const buttons = card.querySelectorAll('.like-btn, .dislike-btn');
        buttons.forEach(btn => btn.disabled = true);
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('dog_id', dogId);
        formData.append('action', action);
        
        // Log the form data being sent
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        fetch('/user/dog-tinder/swipe', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('Swipe response data:', data);
            
            if (data.success) {
                card.classList.add(action === 'like' ? 'swipe-right' : 'swipe-left');
                
                if (data.is_match) {
                    setTimeout(() => {
                        showMatchModal(data.matched_user);
                    }, 500);
                }
                
                setTimeout(() => {
                    card.style.display = 'none';
                    const remainingCards = document.querySelectorAll('.dog-card:not([style*="display: none"])');
                    if (remainingCards.length === 0) {
                        const noDogsMessage = document.querySelector('.no-dogs-message');
                        if (noDogsMessage) noDogsMessage.style.display = 'block';
                    }
                }, 500);
            } else {
                console.error('Swipe error:', data.error);
                alert('Error: ' + (data.error || 'Something went wrong'));
                buttons.forEach(btn => btn.disabled = false);
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            alert('An error occurred: ' + error.message);
            buttons.forEach(btn => btn.disabled = false);
        });
    }
});