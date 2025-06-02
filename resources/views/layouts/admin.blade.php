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
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
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
    <body class="font-sans antialiased gradient-bg min-h-screen">
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
                                <a href="#" 
                                   class="nav-link flex items-center p-3 rounded-lg hover:bg-white/20 transition-all duration-300 hover-scale">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Browse Dogs
                                </a>
                            </li>
                            <li>
                                <a href="#" 
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Bar -->
                <header class="glass-effect border-b border-white/20 shadow-lg">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                @isset($header)
                                    {{ $header }}
                                @else
                                    <h1 class="text-2xl font-semibold text-white">Dashboard</h1>
                                @endisset
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="text-sm text-blue-100">
                                    Welcome back, {{ Auth::user()->name }}! 👋
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Content Area -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>