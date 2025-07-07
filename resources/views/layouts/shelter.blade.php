<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#00809D">
    <title>{{ config('app.name', 'Laravel') }} - Shelter Dashboard</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Shelter Color Scheme */
        :root {
            --shelter-primary: #00809D;
            --shelter-light: #FCECDD;
            --shelter-accent: #FF7601;
            --shelter-secondary: #F3A26D;
        }

        .shelter-bg {
            background-color: var(--shelter-light);
        }

        .shelter-sidebar {
            background-color: var(--shelter-primary);

        }

        .shelter-card {
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .shelter-card:hover {
            border-color: var(--shelter-accent);
        }

        .shelter-button-primary {
            background-color: var(--shelter-accent);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .shelter-button-primary:hover {
            background-color: #e66a01;
        }

        .shelter-button-secondary {
            background-color: var(--shelter-secondary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .shelter-button-secondary:hover {
            background-color: #e8925a;
        }

        .shelter-nav-link {
            color: white;
            padding: 12px 16px;
            border-radius: 6px;
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
        }

        .shelter-nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .shelter-nav-link.active {
            background-color: var(--shelter-accent);
        }

        .shelter-header {
            background-color: #F3A26D;
            border-bottom: 1px solid #F3A26D;
        }
    </style>
</head>

<body class="font-sans antialiased shelter-bg min-h-screen" data-user-id="{{ auth()->id() }}">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 shelter-sidebar text-white flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-white/20">
                <h1 class="text-xl font-bold text-white">🐾 PawPals Shelter</h1>
            </div>
            <!-- Navigation -->
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li><a href="{{ route('shelter.dashboard') }}" class="shelter-nav-link {{ request()->routeIs('shelter.dashboard') ? 'active' : '' }}"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>Dashboard </a></li>
                    <li><a href="{{ route('shelter.dogs.index') }}" class="shelter-nav-link {{ request()->routeIs('shelter.dogs.*') ? 'active' : '' }}"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>Manage Dogs </a></li>
                    <li><a href="{{ route('shelter.applications.index') }}" class="shelter-nav-link {{ request()->routeIs('shelter.applications.*') ? 'active' : '' }}"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>Adoption Applications </a></li>
                </ul>
            </nav>
            <!-- User Info -->
            <div class="p-4 border-t border-white/20">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-white text-gray-800 rounded-full flex items-center justify-center mr-3"><span class="text-sm font-medium">{{substr(Auth::user()->name, 0, 1)}}</span></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{Auth::user()->name}}</p>
                        <p class="text-xs text-gray-400">{{ucfirst(Auth::user()->role)}}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit" class="text-gray-400 hover:text-white transition-all duration-300 p-1 rounded"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg></button></form>
                </div>
            </div>
        </div>
        <!-- Main Content and Chat Sidebar -->
        <div class="flex-1 flex flex-row overflow-hidden">
            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Bar -->
                <header class="flex justify-between items-center p-6 shelter-header">
                    <div class="flex items-center">
                        <h2 class="font-semibold text-sm text-gray-800 leading-tight">@yield('header')</h2>
                    </div>
                    <div class="flex items-center space-x-4"><span class="text-gray-800 text-sm">Welcome, {{ Auth::user()->name }}!</span></div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                    @yield('content')
                </main>
            </div>
            <!-- Chat Sidebar -->
            <div id="chat-sidebar" class="w-80 bg-white text-gray-800 p-4 flex flex-col h-full">
                @include('chat.sidebar')
            </div>
        </div>
    </div>
</body>

</html>