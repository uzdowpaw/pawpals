@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🐕 Dog Tinder</h1>
            <p class="text-gray-600">Swipe to discover amazing dogs!</p>
        </div>

        @if($dogs->count() > 0)
            @foreach($dogs as $dog)
                <div id="dog-card-{{ $dog->id }}" class="dog-card bg-white rounded-xl shadow-lg overflow-hidden mb-4">
                    <!-- Dog Image -->
                    <div class="relative h-96">
                        @if($dog->photos->count() > 0)
                            <img src="{{ asset('storage/' . $dog->photos->first()->file_path) }}" 
                                 alt="{{ $dog->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500 text-6xl">🐕</span>
                            </div>
                        @endif
                        
                        <!-- Gradient overlay -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent h-32"></div>
                        
                        <!-- Dog info overlay -->
                        <div class="absolute bottom-4 left-4 text-white">
                            <h2 class="text-2xl font-bold">{{ $dog->name }}</h2>
                            <p class="text-lg">{{ $dog->age }} years old • {{ $dog->breed }}</p>
                            <p class="text-sm opacity-90">Size: {{ ucfirst($dog->size) }}</p>
                            @if($dog->user)
                                <p class="text-sm opacity-75 mt-1">Owner: {{ $dog->user->name }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Dog details -->
                    <div class="p-6">
                        @if($dog->behavior_description)
                            <div class="mb-4">
                                <h3 class="font-semibold text-gray-900 mb-2">About {{ $dog->name }}</h3>
                                <p class="text-gray-600">{{ $dog->behavior_description }}</p>
                            </div>
                        @endif

                        <!-- Action buttons -->
                        <div class="flex justify-center space-x-8 mt-6">
                            <button onclick="swipeDog({{ $dog->id }}, 'dislike')" 
                                    class="dislike-btn bg-red-500 hover:bg-red-600 text-white rounded-full p-4 transition-colors shadow-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            
                            <button onclick="swipeDog({{ $dog->id }}, 'like')" 
                                    class="like-btn bg-green-500 hover:bg-green-600 text-white rounded-full p-4 transition-colors shadow-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">🎉</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">You've seen all the dogs!</h2>
                <p class="text-gray-600 mb-6">Check back later for new furry friends.</p>
                <a href="{{ route('user.dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors">
                Back to Dashboard
            </a>
            </div>
        @endif
    </div>
</div>

<!-- Match Modal -->
<div id="matchModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-8 max-w-sm mx-4 text-center">
        <div class="text-6xl mb-4">💕</div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">It's a Match!</h2>
        <p id="matchMessage" class="text-gray-600 mb-6"></p>
        <button onclick="closeMatchModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors">
            Continue Browsing
        </button>
    </div>
</div>

@push('scripts')
<script>
function swipeDog(dogId, action) {
    // Disable buttons to prevent double-clicking
    const card = document.getElementById(`dog-card-${dogId}`);
    const buttons = card.querySelectorAll('button');
    buttons.forEach(btn => btn.disabled = true);

    fetch('{{ route("user.dog-tinder.swipe") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            dog_id: dogId,
            action: action
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add animation class
            card.classList.add(action === 'like' ? 'swipe-right' : 'swipe-left');
            
            // Show match modal if it's a match
            if (data.is_match) {
                setTimeout(() => {
                    showMatchModal(data.matched_user);
                }, 500);
            }
            
            // Remove card and load next dog after animation
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            alert('Error: ' + (data.error || 'Something went wrong'));
            buttons.forEach(btn => btn.disabled = false);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
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
}
</script>
@endpush

@push('styles')
<style>
.dog-card {
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
}

.swipe-right {
    transform: translateX(100%) rotate(20deg);
    opacity: 0;
}

.swipe-left {
    transform: translateX(-100%) rotate(-20deg);
    opacity: 0;
}

.like-btn:hover {
    transform: scale(1.1);
}

.dislike-btn:hover {
    transform: scale(1.1);
}
</style>
@endpush
@endsection