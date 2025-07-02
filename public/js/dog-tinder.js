document.addEventListener('DOMContentLoaded', function () {
    // Use event delegation to handle clicks on buttons that might be added dynamically
    document.body.addEventListener('click', function(event) {
        const likeBtn = event.target.closest('.like-btn');
        const dislikeBtn = event.target.closest('.dislike-btn');

        if (likeBtn) {
            const dogId = likeBtn.dataset.dogId;
            swipeDog(dogId, 'like', likeBtn);
        } else if (dislikeBtn) {
            const dogId = dislikeBtn.dataset.dogId;
            swipeDog(dogId, 'dislike', dislikeBtn);
        }
    });
});

function swipeDog(dogId, action, button) {
    const card = document.getElementById(`dog-card-${dogId}`);
    if (!card) return;

    const buttons = card.querySelectorAll('.like-btn, .dislike-btn');
    buttons.forEach(btn => btn.disabled = true);

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('dog_id', dogId);
    formData.append('action', action);

    fetch('/user/dog-tinder/swipe', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Server error');
            }).catch(() => {
                throw new Error(`HTTP error! status: ${response.status}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Swipe response:', data);
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
                    if(noDogsMessage) noDogsMessage.style.display = 'block';
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