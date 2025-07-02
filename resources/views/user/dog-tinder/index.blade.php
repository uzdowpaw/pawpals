<x-user-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">🐕 Browse Dogs</h1>
    </x-slot>

    <div class="text-center mb-6">
        <p class="text-gray-600 dark:text-gray-400">Swipe to discover amazing dogs!</p>
    </div>

    @if($dogs->count() > 0)
    <div class="flex flex-col items-center gap-8 max-w-screen-xl mx-auto px-4">
        @foreach($dogs as $dog)
        <div id="dog-card-{{ $dog->id }}" class="dog-card bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-4 w-full max-w-xl mx-auto">
            <!-- Dog Image -->
            <div class="relative h-[32rem]">
                @if($dog->photos->count() > 0)
                <img src="{{ asset('storage/' . $dog->photos->first()->path) }}"
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
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">About {{ $dog->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $dog->behavior_description }}</p>
                </div>
                @endif

                <!-- Action buttons -->
                <div class="flex justify-center space-x-8 mt-6">
                    <button data-dog-id="{{ $dog->id }}" 
                        class="dislike-btn bg-red-500 hover:bg-red-600 text-white rounded-full p-4 transition-colors shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <button data-dog-id="{{ $dog->id }}"
                        class="like-btn bg-green-500 hover:bg-green-600 text-white rounded-full p-4 transition-colors shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow p-8 no-dogs-message" style="display: none;">
        <div class="text-6xl mb-4">🎉</div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">You've seen all the dogs!</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Check back later for new furry friends.</p>
        <a href="{{ route('user.dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors">
            Back to Dashboard
        </a>
    </div>
    @endif

    <!-- Match Modal -->
    <div id="matchModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-sm mx-4 text-center">
            <div class="text-6xl mb-4">💕</div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">It's a Match!</h2>
            <p id="matchMessage" class="text-gray-600 dark:text-gray-400 mb-6"></p>
            <button onclick="closeMatchModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors">
                Continue Browsing
            </button>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/dog-tinder.js') }}"></script>
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
</x-user-layout>