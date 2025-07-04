<x-user-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-gray-100 dark:text-white">User Dashboard</h1>

        @if(session('upcoming_reminders'))
        <div id="reminder-popup" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-50 h-screen">
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white dark:bg-gray-700 rounded-lg shadow-xl p-6 m-4 max-w-md w-full">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 text-center">Upcoming Reminders!</h2>
                <p class="text-gray-700 dark:text-gray-300 mb-4 text-center">You have pet care reminders due in the next 7 days:</p>
                <ul class="list-disc pl-5 mb-4 text-gray-700 dark:text-gray-300">
                    @foreach(session('upcoming_reminders') as $reminder)
                    <li>{{ $reminder->name }} for {{ $reminder->dog->name }} on {{ \Carbon\Carbon::parse($reminder->reminder_date)->format('M d, Y') }}</li>
                    @endforeach
                </ul>
                <button id="close-popup" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Got it!</button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const closeButton = document.getElementById('close-popup');
                const popup = document.getElementById('reminder-popup');

                if (closeButton && popup) {
                    closeButton.addEventListener('click', function() {
                        popup.style.display = 'none';
                    });
                }
            });
        </script>
        @endif
    </x-slot>

    <!-- User Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Example Stat 1 -->
        <div class="user-card rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #FADFA1;">
                    <svg class="w-6 h-6" style="color: #C96868;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: #C96868;">Your Matches</p>
                    <p class="text-2xl font-semibold" style="color: #C96868;">0</p>
                </div>
            </div>
        </div>

        <!-- Example Stat 2 -->
        <div class="user-card rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #FADFA1;">
                    <svg class="w-6 h-6" style="color: #C96868;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: #C96868;">Dogs Adopted</p>
                    <p class="text-2xl font-semibold" style="color: #C96868;">0</p>
                </div>
            </div>
        </div>

        <!-- Example Stat 3 -->
        <div class="user-card rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #FADFA1;">
                    <svg class="w-6 h-6" style="color: #C96868;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: #C96868;">Pending Adoptions</p>
                    <p class="text-2xl font-semibold" style="color: #C96868;">0</p>
                </div>
            </div>
        </div>

        <!-- Example Stat 4 -->
        <div class="user-card rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #FADFA1;">
                    <svg class="w-6 h-6" style="color: #C96868;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: #C96868;">Favorite Dogs</p>
                    <p class="text-2xl font-semibold" style="color: #C96868;">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <div class="user-card rounded-lg">
            <div class="p-6 border-b" style="border-color: #7EACB5;">
                <h3 class="text-lg font-medium" style="color: #C96868;">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('user.dog-tinder.index') }}" class="flex items-center p-4 border rounded-lg transition-colors" style="border-color: #7EACB5;" onmouseover="this.style.backgroundColor='#FADFA1'" onmouseout="this.style.backgroundColor='transparent'">
                        <svg class="w-8 h-8 mr-3" style="color: #C96868;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium" style="color: #C96868;">Browse Dogs</p>
                            <p class="text-sm" style="color: #7EACB5;">Discover dogs and find your perfect match!</p>
                        </div>
                    </a>
                    <a href="{{ route('user.applications.index') }}" class="flex items-center p-4 border rounded-lg transition-colors" style="border-color: #7EACB5;" onmouseover="this.style.backgroundColor='#FADFA1'" onmouseout="this.style.backgroundColor='transparent'">
                        <svg class="w-8 h-8 mr-3" style="color: #C96868;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium" style="color: #C96868;">View Applications</p>
                            <p class="text-sm" style="color: #7EACB5;">Check status of your adoptions</p>
                        </div>
                    </a>
                    <a href="{{ route('user.adoption-gallery') }}" class="flex items-center p-4 border rounded-lg transition-colors" style="border-color: #7EACB5;" onmouseover="this.style.backgroundColor='#FADFA1'" onmouseout="this.style.backgroundColor='transparent'">
                        <svg class="w-8 h-8 mr-3" style="color: #C96868;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium" style="color: #C96868;">Adopt a Friend</p>
                            <p class="text-sm" style="color: #7EACB5;">Browse our gallery of available dogs</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center p-4 border rounded-lg transition-colors" style="border-color: #7EACB5;" onmouseover="this.style.backgroundColor='#FADFA1'" onmouseout="this.style.backgroundColor='transparent'">
                        <svg class="w-8 h-8 mr-3" style="color: #C96868;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium" style="color: #C96868;">Edit Profile</p>
                            <p class="text-sm" style="color: #7EACB5;">Update your personal information</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Components -->

    <div id="chat-windows"></div>
    <div class="chat-toggle-button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
    </div>
</x-user-layout>