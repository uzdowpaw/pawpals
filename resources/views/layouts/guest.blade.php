<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="PawPals - Connect your dog with perfect playmates in your neighborhood. Safe, verified, and fun dog playdates made easy.">
        <meta name="keywords" content="dog playdate, pet social, dog friends, pet community, dog matching">
        <meta property="og:title" content="PawPals - Where Dogs Make Friends">
        <meta property="og:description" content="Connect your dog with perfect playmates in your neighborhood">
        <meta property="og:type" content="website">
        <meta name="theme-color" content="#4F46E5">

        <title>{{ config('app.name', 'PawPals') }} - Authentication</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * {
                font-family: 'Inter', sans-serif;
            }
            html {
                scroll-behavior: smooth;
            }
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
        </style>
    </head>
    <body class="bg-gray-900 text-white overflow-x-hidden antialiased">
        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 bg-gray-900/80 backdrop-blur-lg border-b border-gray-800">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <span class="text-xl font-bold">🐾</span>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">PawPals</span>
                    </a>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-indigo-400 hover:text-indigo-300 transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 text-gray-300 hover:text-white transition-colors">Sign In</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">Get Started</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <div class="min-h-screen flex flex-col items-center justify-center pt-24 pb-12 bg-gray-900">
            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-gray-800/70 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-700">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <footer id="contact" class="py-12 bg-gray-900 border-t border-gray-800">
            <div class=
