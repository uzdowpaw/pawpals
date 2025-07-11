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
        <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Courier+Prime:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --teal: #03A6A1;
                --cream: #FFE3BB;
                --orange: #FFA673;
                --red-orange: #FF4F0F;
            }

            * {
                font-family: 'Courier Prime', monospace;
            }

            html {
                scroll-behavior: smooth;
            }

            .retro-shadow {
                box-shadow: 5px 5px 0px var(--red-orange);
            }

            .retro-border {
                border: 3px solid var(--red-orange);
            }

            .retro-pattern {
                background-image: radial-gradient(var(--orange) 2px, transparent 2px);
                background-size: 20px 20px;
            }

            .retro-title {
                font-family: 'Pacifico', cursive;
                color: var(--red-orange);
                text-shadow: 3px 3px 0px var(--teal);
            }

            .retro-subtitle {
                font-family: 'Space Mono', monospace;
                letter-spacing: 1px;
            }

            .retro-button {
                background-color: var(--teal);
                color: var(--cream);
                border: 2px solid var(--red-orange);
                box-shadow: 3px 3px 0px var(--red-orange);
                transition: all 0.2s ease;
                transform: translate(0, 0);
            }

            .retro-button:hover {
                transform: translate(-2px, -2px);
                box-shadow: 5px 5px 0px var(--red-orange);
            }

            .retro-button:active {
                transform: translate(2px, 2px);
                box-shadow: 1px 1px 0px var(--red-orange);
            }

            .retro-card {
                border: 2px solid var(--teal);
                box-shadow: 5px 5px 0px var(--orange);
                background-color: var(--cream);
                color: #333;
            }

            .retro-icon-bg {
                background-color: var(--teal);
                border: 2px solid var(--red-orange);
            }

            .retro-circle {
                background-color: var(--orange);
                border: 2px solid var(--red-orange);
            }
        </style>
    </head>
    <body class="bg-[var(--cream)] text-[#333] overflow-x-hidden antialiased">
        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 bg-[var(--teal)] border-b-4 border-[var(--red-orange)]">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-12 h-12 retro-circle rounded-full flex items-center justify-center">
                            <span class="text-xl font-bold">🐾</span>
                        </div>
                        <span class="text-2xl font-bold retro-title">PawPals</span>
                    </a>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-[var(--cream)] hover:text-white font-bold transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 text-[var(--cream)] hover:text-white font-bold transition-colors">Sign In</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-2 retro-button rounded-none font-bold">Get Started</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <div class="min-h-screen flex flex-col items-center justify-center pt-24 pb-12 bg-[var(--cream)]">
            <div class="w-full sm:max-w-md mt-6 px-8 py-10 retro-card overflow-hidden sm:rounded-none">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <footer id="contact" class="py-12 bg-[var(--teal)] border-t-4 border-[var(--red-orange)]">
            <div class=
