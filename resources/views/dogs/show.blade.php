@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/2">
                @if($dog->photos->isNotEmpty())
                <img src="{{ asset('storage/' . $dog->photos->first()->path) }}" alt="{{ $dog->name }}" class="w-full h-full object-cover">
                @else
                <img src="{{ asset('images/default_pet.svg') }}" alt="Default dog image" class="w-full h-full object-cover">
                @endif
            </div>
            <div class="p-8 md:w-1/2">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $dog->name }}</h1>
                <p class="text-xl text-gray-600 dark:text-gray-400">{{ $dog->breed }}</p>
                <p class="text-lg text-gray-500 dark:text-gray-300">{{ $dog->age }} years old</p>
                <div class="mt-4">
                    <span class="inline-block bg-{{ $dog->size === 'small' ? 'blue' : ($dog->size === 'medium' ? 'green' : 'red') }}-200 text-{{ $dog->size === 'small' ? 'blue' : ($dog->size === 'medium' ? 'green' : 'red') }}-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">{{ ucfirst($dog->size) }}</span>
                </div>
                <p class="mt-4 text-gray-700 dark:text-gray-200">{{ $dog->description }}</p>
                <p class="mt-4 text-sm text-gray-700 dark:text-gray-200">Shelter: {{ $dog->shelter->name }}</p>

                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Adoption Form</h2>
                    <form action="{{ route('dogs.adopt', $dog) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-4">
                            <label for="message" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Your Message (optional):</label>
                            <textarea name="message" id="message" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Submit Adoption Application
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection