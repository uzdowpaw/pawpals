@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">My Adoption Applications</h1>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($applications as $application)
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Application for {{ $application->dog->name }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Submitted to: {{ $application->dog->shelter->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Submitted on: {{ $application->created_at->format('F j, Y') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @switch($application->status)
                                    @case('pending')
                                        bg-yellow-100 text-yellow-800
                                        @break
                                    @case('approved')
                                        bg-green-100 text-green-800
                                        @break
                                    @case('rejected')
                                        bg-red-100 text-red-800
                                        @break
                                @endswitch
                            ">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                </div>
                @if($application->message)
                <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-900 rounded-md">
                    <p class="text-sm text-gray-800 dark:text-gray-200"><strong>Your message:</strong> {{ $application->message }}</p>
                </div>
                @endif
            </div>
            @empty
            <div class="p-6 text-center">
                <p class="text-gray-500 dark:text-gray-400">You have not submitted any adoption applications yet.</p>
                <a href="{{ route('dogs.index') }}" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Browse Dogs</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection