@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-12">Meet Our Adoptable Dogs</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach ($dogs as $dog)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out">
            <a href="{{ route('shelter-dogs.show', $dog) }}">
                @if($dog->main_photo_path)
                <img src="{{ asset('storage/' . $dog->main_photo_path) }}" alt="{{ $dog->name }}" class="w-full h-56 object-cover">
                @else
                <img src="{{ asset('images/default_pet.svg') }}" alt="Default dog image" class="w-full h-56 object-cover">
                @endif
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $dog->name }}</h2>
                    <p class="text-md text-gray-600 dark:text-gray-400">{{ $dog->breed->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-300">{{ $dog->age }} years old</p>
                    <p class="text-sm text-gray-500 dark:text-gray-300">{{ ucfirst($dog->sex) }}</p>
                    <p class="mt-4 text-sm text-gray-700 dark:text-gray-200">Shelter: {{ $dog->shelter->name }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection