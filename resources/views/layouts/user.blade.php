<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#4F46E5">

    <title>{{ config('app.name', 'Laravel') }} - User Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
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
        .user-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .user-card:hover {
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
                <h1 class="text-xl font-bold bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">🐾 PawPals</h1>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('user.dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-all duration-300 {{ request()->routeIs('user.dashboard') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.dog-tinder.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-all duration-300 {{ request()->routeIs('user.dog-tinder.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Find Dogs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.applications.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-all duration-300 {{ request()->routeIs('user.applications.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            My Applications
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.adoption-gallery') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-all duration-300 {{ request()->routeIs('user.adoption-gallery') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Adoption Gallery
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.pets.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-all duration-300 {{ request()->routeIs('user.pets.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                            My Pets
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.pet-care.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-all duration-300 {{ request()->routeIs('user.pet-care.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Pet Care
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-all duration-300 {{ request()->routeIs('profile.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            My Profile
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-white/20">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                        <span class="text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white transition-all duration-300 p-1 rounded">
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
                <header class="flex justify-between items-center p-6 bg-gray-800 shadow-md glass-effect">
                    <div class="flex items-center">
                        <h2 class="font-semibold text-sm text-white leading-tight">
                            {{ $header ?? '' }}
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

    <!-- Chat Components -->
    <div id="chat-windows"></div>
    <div class="chat-toggle-button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
    </div>
    
    <!-- Scripts Stack -->
    @stack('scripts')
</body>

</html>