<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PawPals - Connect your dog with perfect playmates in your neighborhood. Safe, verified, and fun dog playdates made easy.">
    <meta name="keywords" content="dog playdate, pet social, dog friends, pet community, dog matching">
    <meta property="og:title" content="PawPals - Where Dogs Make Friends">
    <meta property="og:description" content="Connect your dog with perfect playmates in your neighborhood">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#03A6A1">
    <title>PawPals - Where Dogs Make Friends</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Courier+Prime:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
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

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }

            from {
                opacity: 0;
                transform: translateY(20px);
            }
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .retro-shadow {
            box-shadow: 5px 5px 0px #FF4F0F;
        }

        .retro-border {
            border: 3px solid #FF4F0F;
        }

        .retro-pattern {
            background-image: radial-gradient(#FFA673 2px, transparent 2px);
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

<body class="bg-[#FFE3BB] text-[#333] overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-[#03A6A1] border-b-4 border-[#FF4F0F]">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-12 h-12 retro-circle rounded-full flex items-center justify-center">
                        <span class="text-xl font-bold">🐾</span>
                    </div>
                    <span class="text-2xl font-bold retro-title">PawPals</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-[#FFE3BB] hover:text-white font-bold transition-colors">Features</a>
                    <a href="#how-it-works" class="text-[#FFE3BB] hover:text-white font-bold transition-colors">How It Works</a>
                    <a href="#testimonials" class="text-[#FFE3BB] hover:text-white font-bold transition-colors">Reviews</a>
                    <a href="#contact" class="text-[#FFE3BB] hover:text-white font-bold transition-colors">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-[#FFE3BB] hover:text-white font-bold transition-colors">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-[#FFE3BB] hover:text-white font-bold transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="px-6 py-2 retro-button rounded-none font-bold">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 min-h-screen flex items-center relative overflow-hidden">
        <div class="absolute inset-0 retro-pattern opacity-10"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="flex-1 text-center lg:text-left fade-in">

                    <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight retro-title">
                        Where Dogs Make
                        <span class="block">Friends</span>
                    </h1>
                    <p class="text-xl text-[#333] mb-8 leading-relaxed max-w-2xl retro-subtitle">
                        Connect your furry friend with perfect playmates in your neighborhood. Safe, verified, and tail-waggingly fun adventures await!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-6 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-[#FF4F0F] text-[#FFE3BB] text-lg font-bold border-2 border-[#03A6A1] retro-shadow hover:translate-y-[-2px] hover:translate-x-[-2px] transition-all">
                            START MATCHING
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="#how-it-works" class="inline-flex items-center px-8 py-4 text-lg font-bold text-[#03A6A1] bg-[#FFE3BB] border-2 border-[#03A6A1] retro-shadow hover:translate-y-[-2px] hover:translate-x-[-2px] transition-all">
                            WATCH DEMO
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.5a2.5 2.5 0 110 5H9V10z"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="flex items-center gap-8 mt-12 justify-center lg:justify-start">
                        <div class="text-center bg-[#FFA673] p-3 border-2 border-[#FF4F0F] retro-shadow">
                            <div class="text-3xl font-bold text-[#03A6A1]">10K+</div>
                            <div class="text-[#333] text-sm font-bold">HAPPY DOGS</div>
                        </div>
                        <div class="text-center bg-[#FFA673] p-3 border-2 border-[#FF4F0F] retro-shadow">
                            <div class="text-3xl font-bold text-[#03A6A1]">5K+</div>
                            <div class="text-[#333] text-sm font-bold">PLAYDATES</div>
                        </div>
                        <div class="text-center bg-[#FFA673] p-3 border-2 border-[#FF4F0F] retro-shadow">
                            <div class="text-3xl font-bold text-[#03A6A1]">50+</div>
                            <div class="text-[#333] text-sm font-bold">CITIES</div>
                        </div>
                    </div>
                </div>
                <div class="flex-1 fade-in" style="animation-delay: 0.2s">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#FF4F0F] translate-x-4 translate-y-4 rounded-none"></div>
                        <img src="{{ asset('img/hero.jpg') }}" alt="Happy dogs playing together" class="relative z-10 w-full max-w-lg mx-auto border-4 border-[#03A6A1] hover-scale transition-all duration-500">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-[#03A6A1]">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="inline-block bg-[#FF4F0F] text-[#FFE3BB] font-bold px-4 py-1 mb-4 retro-shadow border-2 border-[#FFE3BB]">FEATURES</span>
                <h2 class="text-4xl font-bold text-[#FFE3BB] mb-6 leading-tight retro-title">Everything Your Dog Needs</h2>
                <p class="text-[#FFE3BB] text-lg max-w-2xl mx-auto retro-subtitle">Discover why thousands of dog parents trust PawPals for their furry friends' social lives.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="retro-card p-8 hover-scale transition-all duration-300 fade-in" style="animation-delay: 0.1s">
                    <div class="retro-icon-bg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-[#FFE3BB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#FF4F0F] mb-4 text-center">VERIFIED PROFILES</h3>
                    <p class="text-[#333] leading-relaxed text-center">Every dog and owner goes through our verification process to ensure a safe and trusted community.</p>
                </div>
                <div class="retro-card p-8 hover-scale transition-all duration-300 fade-in" style="animation-delay: 0.2s">
                    <div class="retro-icon-bg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-[#FFE3BB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#FF4F0F] mb-4 text-center">SMART MATCHING</h3>
                    <p class="text-[#333] leading-relaxed text-center">Our AI algorithm matches dogs based on size, energy level, play style, and location for perfect compatibility.</p>
                </div>
                <div class="retro-card p-8 hover-scale transition-all duration-300 fade-in" style="animation-delay: 0.3s">
                    <div class="retro-icon-bg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-[#FFE3BB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#FF4F0F] mb-4 text-center">REAL-TIME CHAT</h3>
                    <p class="text-[#333] leading-relaxed text-center">Connect with other pet parents instantly through our secure messaging system to plan the perfect playdate.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-[#FFE3BB] retro-pattern">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="inline-block bg-[#FF4F0F] text-[#FFE3BB] font-bold px-4 py-1 mb-4 retro-shadow border-2 border-[#FFE3BB]">HOW IT WORKS</span>
                <h2 class="text-4xl font-bold text-[#03A6A1] mb-6 leading-tight retro-title">Simple Steps to Find Your Dog's New Friends</h2>
                <p class="text-[#333] text-lg max-w-2xl mx-auto retro-subtitle">Getting started with PawPals is easy. Follow these simple steps and your dog will be socializing in no time.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center fade-in" style="animation-delay: 0.1s">
                    <div class="w-20 h-20 bg-[#FF4F0F] retro-circle flex items-center justify-center text-[#FFE3BB] text-2xl font-bold mx-auto mb-6">1</div>
                    <h3 class="text-xl font-bold text-[#03A6A1] mb-4 retro-step-title">CREATE PROFILE</h3>
                    <p class="text-[#333] leading-relaxed">Sign up and create a detailed profile for your dog, including photos, personality traits, and preferences.</p>
                </div>
                <div class="text-center fade-in" style="animation-delay: 0.2s">
                    <div class="w-20 h-20 bg-[#FF4F0F] retro-circle flex items-center justify-center text-[#FFE3BB] text-2xl font-bold mx-auto mb-6">2</div>
                    <h3 class="text-xl font-bold text-[#03A6A1] mb-4 retro-step-title">FIND MATCHES</h3>
                    <p class="text-[#333] leading-relaxed">Browse through compatible dogs in your area and send connection requests to potential playmates.</p>
                </div>
                <div class="text-center fade-in" style="animation-delay: 0.3s">
                    <div class="w-20 h-20 bg-[#FF4F0F] retro-circle flex items-center justify-center text-[#FFE3BB] text-2xl font-bold mx-auto mb-6">3</div>
                    <h3 class="text-xl font-bold text-[#03A6A1] mb-4 retro-step-title">SCHEDULE PLAYDATES</h3>
                    <p class="text-[#333] leading-relaxed">Chat with other owners, plan meetups, and watch your dog make lifelong friendships!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-[#FFA673]">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="inline-block bg-[#FF4F0F] text-[#FFE3BB] font-bold px-4 py-1 mb-4 retro-shadow border-2 border-[#FFE3BB]">TESTIMONIALS</span>
                <h2 class="text-4xl font-bold text-[#03A6A1] mb-6 leading-tight retro-title">What Pet Parents Say</h2>
                <p class="text-[#333] text-lg max-w-2xl mx-auto retro-subtitle">Don't just take our word for it - hear from our amazing community of dog lovers!</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="retro-testimonial p-8 hover-scale transition-all duration-300 fade-in" style="animation-delay: 0.1s">
                    <div class="flex text-[#FF4F0F] mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-[#333] leading-relaxed mb-6 retro-quote">"PawPals has been a game-changer for my shy Golden Retriever! He's made so many friends and really come out of his shell."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-[#03A6A1] border-4 border-[#FF4F0F] retro-shadow rounded-full flex items-center justify-center mr-4">
                            <span class="text-[#FFE3BB] font-bold">SJ</span>
                        </div>
                        <div>
                            <h4 class="text-[#03A6A1] font-bold">Sarah Johnson</h4>
                            <p class="text-[#FF4F0F] text-sm font-bold">Dog Parent of Max</p>
                        </div>
                    </div>
                </div>
                <div class="retro-testimonial p-8 hover-scale transition-all duration-300 fade-in" style="animation-delay: 0.2s">
                    <div class="flex text-[#FF4F0F] mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-[#333] leading-relaxed mb-6 retro-quote">"The location-based matching is perfect! We've found several playmates right in our neighborhood. Luna loves her new friends!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-[#03A6A1] border-4 border-[#FF4F0F] retro-shadow rounded-full flex items-center justify-center mr-4">
                            <span class="text-[#FFE3BB] font-bold">MC</span>
                        </div>
                        <div>
                            <h4 class="text-[#03A6A1] font-bold">Michael Chen</h4>
                            <p class="text-[#FF4F0F] text-sm font-bold">Dog Parent of Luna</p>
                        </div>
                    </div>
                </div>
                <div class="retro-testimonial p-8 hover-scale transition-all duration-300 fade-in" style="animation-delay: 0.3s">
                    <div class="flex text-[#FF4F0F] mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-[#333] leading-relaxed mb-6 retro-quote">"The verification system gives me peace of mind when meeting new dogs and their owners. Highly recommended for any dog parent!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-[#03A6A1] border-4 border-[#FF4F0F] retro-shadow rounded-full flex items-center justify-center mr-4">
                            <span class="text-[#FFE3BB] font-bold">ER</span>
                        </div>
                        <div>
                            <h4 class="text-[#03A6A1] font-bold">Emily Rodriguez</h4>
                            <p class="text-[#FF4F0F] text-sm font-bold">Dog Parent of Bella</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-[#03A6A1] retro-pattern-dots">
        <div class="container mx-auto px-6 text-center">
            <div class="bg-[#FFA673] p-12 retro-shadow retro-border hover-scale transition-all duration-500 fade-in relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold text-[#03A6A1] mb-8 leading-tight retro-title">Ready to Find the Perfect Playmate?</h2>
                    <p class="text-[#333] text-lg mb-8 max-w-2xl mx-auto retro-subtitle">Join thousands of happy dog parents who have found the perfect companions for their furry friends. Your dog's best friend is just a click away!</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 text-lg font-bold text-[#FFE3BB] bg-[#FF4F0F] border-4 border-[#03A6A1] retro-shadow hover:translate-y-[-2px] hover:translate-x-[-2px] transition-all">
                            Get Started Free
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="#features" class="inline-flex items-center px-8 py-4 text-lg font-bold text-[#03A6A1] bg-[#FFE3BB] border-4 border-[#03A6A1] retro-shadow hover:translate-y-[-2px] hover:translate-x-[-2px] transition-all">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-[#FFE3BB] py-16 retro-pattern">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-12 h-12 retro-circle rounded-full flex items-center justify-center">
                            <span class="text-xl font-bold">🐾</span>
                        </div>
                        <span class="text-2xl font-bold retro-title">PawPals</span>
                    </div>
                    <p class="text-[#333] leading-relaxed">Connecting dogs and their humans for happier, more social lives. Building the largest community of dog lovers worldwide.</p>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-[#03A6A1] mb-6 retro-subtitle">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">About Us</a></li>
                        <li><a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">Safety Guidelines</a></li>
                        <li><a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">Community Rules</a></li>
                        <li><a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">Support Center</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-[#03A6A1] mb-6 retro-subtitle">Legal</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">Cookie Policy</a></li>
                        <li><a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">GDPR Compliance</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-[#03A6A1] mb-6 retro-subtitle">Connect With Us</h4>
                    <div class="flex space-x-4 mb-6">
                        <a href="#" class="w-10 h-10 bg-[#FFA673] retro-shadow border-2 border-[#FF4F0F] rounded-none flex items-center justify-center text-[#03A6A1] hover:text-[#FFE3BB] hover:bg-[#FF4F0F] transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-[#FFA673] retro-shadow border-2 border-[#FF4F0F] rounded-none flex items-center justify-center text-[#03A6A1] hover:text-[#FFE3BB] hover:bg-[#FF4F0F] transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-[#FFA673] retro-shadow border-2 border-[#FF4F0F] rounded-none flex items-center justify-center text-[#03A6A1] hover:text-[#FFE3BB] hover:bg-[#FF4F0F] transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                            </svg>
                        </a>
                    </div>
                    <p class="text-[#333] text-sm">Follow us for daily dose of adorable dog content!</p>
                </div>
            </div>
            <div class="border-t-4 border-[#03A6A1] pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-[#333] text-sm mb-4 md:mb-0">&copy; 2024 PawPals. All rights reserved. Made with ❤️ for dogs everywhere.</p>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">Sitemap</a>
                        <a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">Accessibility</a>
                        <a href="#" class="text-[#333] hover:text-[#FF4F0F] transition-colors">Status</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    </script>
</body>

</html>