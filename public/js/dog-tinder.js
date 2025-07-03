document.addEventListener('DOMContentLoaded', function () {
    console.log('Dog Tinder JS loaded - Fixed SVG Version with Direct SVG Handlers');
    
    // Fix for SVG elements inside buttons
    function fixSvgClickHandling() {
        // Make SVG elements pointer-events: none so clicks pass through to the button
        const svgElements = document.querySelectorAll('button svg, button path');
        svgElements.forEach(svg => {
            svg.style.pointerEvents = 'none';
            
            // Add a direct click handler to the SVG element
            svg.addEventListener('click', function(e) {
                console.log('SVG element clicked directly');
                e.preventDefault();
                e.stopPropagation();
                
                // Find the parent button
                const button = this.closest('.like-btn, .dislike-btn');
                if (button) {
                    console.log('Found parent button:', button);
                    // Trigger a click on the parent button
                    button.click();
                }
            });
        });
        console.log(`Applied pointer-events:none and click handlers to ${svgElements.length} SVG elements`);
    }
    
    // Run the SVG fix
    fixSvgClickHandling();
    
    // Direct event listeners for buttons
    const likeButtons = document.querySelectorAll('.like-btn');
    const dislikeButtons = document.querySelectorAll('.dislike-btn');
    
    console.log('Found like buttons:', likeButtons.length);
    console.log('Found dislike buttons:', dislikeButtons.length);
    
    // Add click handlers to each button
    likeButtons.forEach(button => {
        // Mark button as having handler attached
        button.setAttribute('data-handler-attached', 'true');
        
        // Add the click handler
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Like button clicked directly');
            const dogId = this.getAttribute('data-dog-id');
            if (!dogId) {
                console.error('No dog ID found on button:', this);
                return;
            }
            swipeDog(dogId, 'like', this);
        });
        
        // Also handle mousedown event as a fallback
        button.addEventListener('mousedown', function(e) {
            console.log('Like button mousedown event');
        });
    });
    
    dislikeButtons.forEach(button => {
        // Mark button as having handler attached
        button.setAttribute('data-handler-attached', 'true');
        
        // Add the click handler
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Dislike button clicked directly');
            const dogId = this.getAttribute('data-dog-id');
            if (!dogId) {
                console.error('No dog ID found on button:', this);
                return;
            }
            swipeDog(dogId, 'dislike', this);
        });
        
        // Also handle mousedown event as a fallback
        button.addEventListener('mousedown', function(e) {
            console.log('Dislike button mousedown event');
        });
    });
    
    // Also keep event delegation as a fallback
    document.body.addEventListener('click', function (event) {
        console.log('Body click event on:', event.target);
        
        const likeBtn = event.target.closest('.like-btn');
        const dislikeBtn = event.target.closest('.dislike-btn');

        if (likeBtn) {
            console.log('Like button clicked via delegation');
            const dogId = likeBtn.getAttribute('data-dog-id');
            if (!dogId) {
                console.error('No dog ID found on button via delegation:', likeBtn);
                return;
            }
            swipeDog(dogId, 'like', likeBtn);
        } else if (dislikeBtn) {
            console.log('Dislike button clicked via delegation');
            const dogId = dislikeBtn.getAttribute('data-dog-id');
            if (!dogId) {
                console.error('No dog ID found on button via delegation:', dislikeBtn);
                return;
            }
            swipeDog(dogId, 'dislike', dislikeBtn);
        }
    });
});

function swipeDog(dogId, action, button) {
    console.log(`Swiping dog ${dogId} with action ${action}`);
    console.log('Button element:', button);
    
    // Validate inputs
    if (!dogId) {
        console.error('Invalid dog ID:', dogId);
        return;
    }
    
    if (action !== 'like' && action !== 'dislike') {
        console.error('Invalid action:', action);
        return;
    }
    
    // Log the current URL for debugging
    console.log('Current page URL:', window.location.href);
    console.log('Current page path:', window.location.pathname);
    
    const card = document.getElementById(`dog-card-${dogId}`);
    if (!card) {
        console.error(`Dog card not found for ID: ${dogId}`);
        return;
    }

    const buttons = card.querySelectorAll('.like-btn, .dislike-btn');
    buttons.forEach(btn => btn.disabled = true);
    
    // Find the next card to prepare for animation
    const allCards = document.querySelectorAll('.dog-card');
    let nextCard = null;
    let foundCurrent = false;
    
    allCards.forEach(c => {
        if (foundCurrent && !nextCard && !c.classList.contains('swipe-left') && !c.classList.contains('swipe-right')) {
            nextCard = c;
        }
        if (c === card) {
            foundCurrent = true;
        }
    });
    
    if (nextCard) {
        // Prepare next card for animation
        nextCard.style.zIndex = '0';
    }

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found!');
        alert('CSRF token not found. Please refresh the page.');
        buttons.forEach(btn => btn.disabled = false);
        return;
    }
    
    const token = csrfToken.getAttribute('content');
    console.log('Using CSRF token:', token);

    const formData = new FormData();
    formData.append('_token', token);
    formData.append('dog_id', dogId);
    formData.append('action', action);
    
    // Log the form data being sent
    console.log('Sending data:', {
        dog_id: dogId,
        action: action,
        token_length: token.length
    });

    // Get the full URL for the swipe endpoint
    const swipeUrl = '/user/dog-tinder/swipe';
    console.log('Sending request to:', swipeUrl);
    
    fetch(swipeUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
        },
        credentials: 'same-origin'
    })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', [...response.headers.entries()]);
            
            if (!response.ok) {
                console.error('Response not OK:', response.status, response.statusText);
                return response.json().then(err => {
                    console.error('Error response body:', err);
                    throw new Error(err.message || 'Server error');
                }).catch(jsonError => {
                    console.error('Error parsing JSON from error response:', jsonError);
                    throw new Error(`HTTP error! status: ${response.status}`);
                });
            }
            
            console.log('Response OK, parsing JSON');
            return response.json().catch(jsonError => {
                console.error('Error parsing JSON from successful response:', jsonError);
                throw new Error('Failed to parse server response');
            });
        })
        .then(data => {
            console.log('Swipe response data:', data);
            
            if (data.success) {
                console.log(`Successful swipe (${action}) for dog ${dogId}`);
                
                // Apply swipe animation class
                card.classList.add(action === 'like' ? 'swipe-right' : 'swipe-left');

                // Find the next card to animate
                const allCards = document.querySelectorAll('.dog-card');
                let nextCard = null;
                let foundCurrent = false;
                
                allCards.forEach(c => {
                    if (foundCurrent && !nextCard && 
                        !c.classList.contains('swipe-left') && 
                        !c.classList.contains('swipe-right') && 
                        !c.style.display === 'none') {
                        nextCard = c;
                    }
                    if (c === card) {
                        foundCurrent = true;
                    }
                });

                if (data.is_match) {
                    console.log('Match found with:', data.matched_user);
                    setTimeout(() => {
                        showMatchModal(data.matched_user);
                    }, 500);
                }

                // After swipe animation completes
                setTimeout(() => {
                    card.style.display = 'none';
                    
                    // Animate the next card if it exists
                    if (nextCard) {
                        nextCard.classList.add('next-card');
                        nextCard.style.zIndex = '1';
                    }
                    
                    const remainingCards = document.querySelectorAll('.dog-card:not([style*="display: none"])');
                    console.log(`${remainingCards.length} dog cards remaining`);
                    
                    if (remainingCards.length === 0) {
                        const noDogsMessage = document.querySelector('.no-dogs-message');
                        if (noDogsMessage) {
                            console.log('No more dogs, showing message');
                            noDogsMessage.style.display = 'block';
                        } else {
                            console.log('No dogs message element not found');
                            const container = document.querySelector('.dog-cards-container');
                            if (container) {
                                container.innerHTML = '<div class="no-more-dogs">No more dogs to show right now. Check back later!</div>';
                            }
                        }
                    }
                }, 500);

            } else {
                console.error('Swipe error from server:', data.error);
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

function showMatchModal(matchedUser) {
    document.getElementById('matchMessage').textContent = `💕 You and ${matchedUser} liked each other's dogs!`;
    document.getElementById('matchModal').classList.remove('hidden');
    document.getElementById('matchModal').classList.add('flex');
}

function closeMatchModal() {
    document.getElementById('matchModal').classList.add('hidden');
    document.getElementById('matchModal').classList.remove('flex');
    // After closing the modal, we might want to load the next dog or just continue
    // For now, we do nothing, the user can continue swiping if there are more dogs.
}