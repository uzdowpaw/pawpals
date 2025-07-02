<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#4F46E5">

    <title>{{ config('app.name', 'Laravel') }} - Admin Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #a8e063 0%, #56ab2f 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        /* Enhanced Glass Sidebar */
        .glass-sidebar {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(147, 51, 234, 0.15));
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Navigation Link Effects */
        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #60a5fa, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Background Animation */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Card Hover Effects */
        .admin-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .admin-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body class="font-sans antialiased gradient-bg min-h-screen" data-user-id="{{ auth()->id() }}">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 glass-sidebar text-white flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-white/20">
                <h1 class="text-xl font-bold bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">🐾 PawPals Admin</h1>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    @if(Auth::user()->role === 'admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Admin Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pets.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('admin.pets.*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Manage Pets
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.adoptions.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('admin.adoptions.*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Adoption Requests
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('admin.users.*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Manage Users
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role === 'shelter')
                    <li>
                        <a href="{{ route('shelter.dashboard') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('shelter.dashboard') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Shelter Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shelter.dogs.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('shelter.dogs.*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Manage Dogs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shelter.applications.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('shelter.applications.*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Adoption Applications
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role === 'user')
                    <li>
                        <a href="{{ route('user.dashboard') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('user.dashboard') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            User Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.pets.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('user.pets.index') || request()->routeIs('user.pets.create') || request()->routeIs('user.pets.edit') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            My Pets
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.pet-care.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('user.pet-care.*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Pet Care
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.dog-tinder.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Browse Dogs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.applications.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            My Applications
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}"
                            class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale {{ request()->routeIs('profile.edit') ? 'bg-white/20 shadow-lg' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Profile
                        </a>
                    </li>

                    @endif
                </ul>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-white/20">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-3 shadow-lg">
                        <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-blue-200">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-blue-200 hover:text-white transition-all duration-300 hover-scale p-1 rounded">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content and Chat Sidebar -->
        <div class="flex-1 flex flex-row overflow-hidden">
            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Bar -->
                <header class="flex justify-between items-center p-6 bg-white/10 backdrop-blur-lg shadow-md">
                    <div class="flex items-center">
                        <h2 class="font-semibold text-sm text-white leading-tight">
                            {{ $header ?? 'Dashboard' }}
                        </h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="notification-bell" class="text-white hover:text-gray-300 transition duration-300 ease-in-out relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                                @endif
                            </button>
                        </div>
                        <span class="text-white text-sm">Welcome, {{ Auth::user()->name }}!</span>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>

            <!-- Chat Sidebar -->
            <div id="chat-sidebar" class="w-80 bg-gray-800 bg-opacity-50 backdrop-blur-md text-white p-4 border-l border-gray-700 flex flex-col h-full">
                @include('chat.sidebar')
            </div>
        </div>
    </div>

    <!-- Chat Windows (if needed, can be positioned relative to chat-sidebar or globally) -->
    <div id="chat-windows-container">
        @include('chat.windows')
    </div>

    <!-- Notification Modal -->
    <div id="notification-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md relative">
            <h3 class="text-lg font-semibold mb-4">Notifications</h3>
            <button id="close-modal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div id="notifications-content" class="max-h-80 overflow-y-auto">
                <!-- Notifications will be loaded here -->
                <p class="text-gray-500">Loading notifications...</p>
            </div>
            <div class="mt-4 text-right">

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBell = document.getElementById('notification-bell');
            const notificationModal = document.getElementById('notification-modal');
            const closeModal = document.getElementById('close-modal');
            const notificationsContent = document.getElementById('notifications-content');

            notificationBell.addEventListener('click', function() {
                notificationModal.classList.remove('hidden');
                fetchNotifications();
            });

            closeModal.addEventListener('click', function() {
                notificationModal.classList.add('hidden');
            });

            notificationModal.addEventListener('click', function(e) {
                if (e.target === notificationModal) {
                    notificationModal.classList.add('hidden');
                }
            });

            function fetchNotifications() {
                notificationsContent.innerHTML = '<p class="text-gray-500">Loading notifications...</p>';
                fetch('/user/notifications/latest') // This route needs to be defined
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.text(); // Get raw text to debug
                    })
                    .then(text => {
                        console.log('Raw response text:', text);
                        const data = JSON.parse(text); // Manually parse after logging

                        if (data.length > 0) {
                            notificationsContent.innerHTML = '';
                            data.forEach(notification => {
                                const notificationElement = document.createElement('div');
                                notificationElement.classList.add('p-3', 'border-b', 'border-gray-200', 'last:border-b-0');
                                notificationElement.innerHTML = `
                                        <p class="font-semibold">${notification.data.message}</p>
                                        <p class="text-sm text-gray-600">${new Date(notification.created_at).toLocaleString()}</p>
                                        ${notification.read_at ? '' : '<span class="text-xs text-blue-500">New</span>'}
                                    `;
                                notificationsContent.appendChild(notificationElement);
                            });
                        } else {
                            notificationsContent.innerHTML = '<p class="text-gray-500">No new notifications.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching notifications:', error);
                        // Ensure 'text' is accessible here, if it was defined in the previous .then()
                        // If the error occurs before .then(text => ...), 'text' might not be defined.
                        // For now, we'll assume 'text' is available from the previous successful response.text() call
                        // or handle the case where it might not be.
                        notificationsContent.innerHTML = `<p class="text-red-500">Failed to load notifications.</p><p class="text-red-500">Raw response (for debugging):</p><pre class="text-xs text-red-400 whitespace-pre-wrap">${error.message}</pre>`;
                    });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>