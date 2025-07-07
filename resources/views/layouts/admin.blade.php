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

        /* Admin Color Scheme */
        .admin-bg {
            background-color: #FFF4EA;
        }

        .admin-sidebar {
            background-color: #DA6C6C;
            border-right: 1px solid #CD5656;
        }

        .admin-card {
            background-color: #EAEBD0;

            transition: all 0.3s ease;
        }

        .admin-card:hover {
            background-color: #FFF4EA;
            border-color: #AF3E3E;
        }

        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(205, 86, 86, 0.3);
        }

        .nav-link.active {
            background-color: rgba(205, 86, 86, 0.5);
        }

        .admin-button-primary {
            background-color: #DA6C6C;
            color: #FFF4EA;
            border: 1px solid #CD5656;
        }

        .admin-button-primary:hover {
            background-color: #CD5656;
            border-color: #AF3E3E;
        }

        .admin-button-secondary {
            background-color: #EAEBD0;
            color: #AF3E3E;
            border: 1px solid #CD5656;
        }

        .admin-button-secondary:hover {
            background-color: #FFF4EA;
            border-color: #AF3E3E;
        }

        .admin-text-primary {
            color: #DA6C6C;
        }

        .admin-text-secondary {
            color: #AF3E3E;
        }

        .admin-text-neutral {
            color: #FFF4EA;
        }
    </style>
</head>

<body class="font-sans antialiased admin-bg min-h-screen" data-user-id="{{ auth()->id() }}">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 admin-sidebar admin-text-neutral flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-opacity-30" style="border-color: #CD5656;">
                <h1 class="text-xl font-bold admin-text-neutral">🐾 PawPals Admin</h1>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    @if(Auth::user()->role === 'admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Admin Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pets.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('admin.pets.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Manage Pets
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.adoptions.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('admin.adoptions.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Adoption Requests
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
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
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('shelter.dashboard') ? 'active' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Shelter Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shelter.dogs.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('shelter.dogs.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Manage Dogs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shelter.applications.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('shelter.applications.*') ? 'active' : '' }}">
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
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            User Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.pets.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('user.pets.index') || request()->routeIs('user.pets.create') || request()->routeIs('user.pets.edit') ? 'active' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            My Pets
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.pet-care.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('user.pet-care.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Pet Care
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.dog-tinder.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Browse Dogs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.applications.index') }}"
                            class="nav-link flex items-center p-3 rounded-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            My Applications
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}"
                            class="nav-link flex items-center p-3 rounded-lg {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
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
            <div class="p-4 border-t border-opacity-30" style="border-color: #CD5656;">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3" style="background-color: #CD5656;">
                        <span class="text-sm font-medium admin-text-neutral">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium admin-text-neutral">{{ Auth::user()->name }}</p>
                        <p class="text-xs" style="color: #EAEBD0;">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="admin-text-neutral hover:opacity-80 transition-all duration-300 p-1 rounded">
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
                <header class="flex justify-between items-center p-6 admin-card">
                    <div class="flex items-center">
                        <h2 class="font-semibold text-sm admin-text-secondary leading-tight">
                            {{ $header ?? 'Dashboard' }}
                        </h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="notification-bell" class="admin-text-secondary hover:opacity-80 transition duration-300 ease-in-out relative">
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
                        <span class="admin-text-secondary text-sm">Welcome, {{ Auth::user()->name }}!</span>
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
            <div id="chat-sidebar" class="w-80 admin-card admin-text-secondary p-4 flex flex-col h-full" style="border-color: #CD5656;">
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
        <div class="admin-card p-6 rounded-lg shadow-xl w-full max-w-md relative">
            <h3 class="text-lg font-semibold mb-4 admin-text-primary">Notifications</h3>
            <button id="close-modal" class="absolute top-3 right-3 admin-text-secondary hover:opacity-80">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div id="notifications-content" class="max-h-80 overflow-y-auto">
                <!-- Notifications will be loaded here -->
                <p class="admin-text-secondary">Loading notifications...</p>
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
                notificationsContent.innerHTML = '<p class="admin-text-secondary">Loading notifications...</p>';
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
                                notificationElement.classList.add('p-3', 'border-b', 'last:border-b-0');
                                notificationElement.style.borderColor = '#CD5656';
                                notificationElement.innerHTML = `
                                        <p class="font-semibold admin-text-primary">${notification.data.message}</p>
                                        <p class="text-sm admin-text-secondary">${new Date(notification.created_at).toLocaleString()}</p>
                                        ${notification.read_at ? '' : '<span class="text-xs admin-text-primary">New</span>'}
                                    `;
                                notificationsContent.appendChild(notificationElement);
                            });
                        } else {
                            notificationsContent.innerHTML = '<p class="admin-text-secondary">No new notifications.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching notifications:', error);
                        // Ensure 'text' is accessible here, if it was defined in the previous .then()
                        // If the error occurs before .then(text => ...), 'text' might not be defined.
                        // For now, we'll assume 'text' is available from the previous successful response.text() call
                        // or handle the case where it might not be.
                        notificationsContent.innerHTML = `<p class="admin-text-primary">Failed to load notifications.</p><p class="admin-text-primary">Raw response (for debugging):</p><pre class="text-xs admin-text-secondary whitespace-pre-wrap">${error.message}</pre>`;
                    });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>