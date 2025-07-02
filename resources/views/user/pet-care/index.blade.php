<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pet Care Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Navigation Buttons -->
            @if($pets->count() > 0)
                @php($firstPet = $pets->first())
                <div class="mb-6 flex justify-end space-x-4">
                    <a href="{{ route('user.pet-care.pet.reminders.create', $firstPet) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Add Reminder
                    </a>
                    <a href="{{ route('user.pet-care.pet.logs.create', $firstPet) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        Add Log Entry
                    </a>
                </div>
            @endif

            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Overdue Reminders -->
                <div class="bg-red-50 dark:bg-red-900/20 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-red-900 dark:text-red-100">Overdue Reminders</h3>
                                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $overdueReminders->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Reminders -->
                <div class="bg-yellow-50 dark:bg-yellow-900/20 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-yellow-900 dark:text-yellow-100">Upcoming Reminders</h3>
                                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $upcomingReminders->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pets -->
                <div class="bg-blue-50 dark:bg-blue-900/20 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100">Your Pets</h3>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $pets->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overdue Reminders Section -->
            @if($overdueReminders->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-red-600 dark:text-red-400 mb-4">⚠️ Overdue Reminders</h3>
                    <div class="space-y-3">
                        @foreach($overdueReminders as $reminder)
                        <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $reminder->title }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $reminder->dog->name }} • {{ $reminder->reminder_date->format('M j, Y g:i A') }}</p>
                                @if($reminder->description)
                                <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">{{ $reminder->description }}</p>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('user.pet-care.reminders.complete', $reminder) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                        Mark Complete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Upcoming Reminders Section -->
            @if($upcomingReminders->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">📅 Upcoming Reminders</h3>
                    <div class="space-y-3">
                        @foreach($upcomingReminders as $reminder)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $reminder->title }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $reminder->dog->name }} • {{ $reminder->reminder_date->format('M j, Y g:i A') }}</p>
                                @if($reminder->description)
                                <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">{{ $reminder->description }}</p>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('user.pet-care.reminders.complete', $reminder) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                        Mark Complete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Your Pets Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">🐕 Your Pets</h3>
                    @if($pets->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($pets as $pet)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                @if($pet->photos->where('is_main', true)->first())
                                <img src="{{ Storage::url($pet->photos->where('is_main', true)->first()->path) }}"
                                    alt="{{ $pet->name }}"
                                    class="w-12 h-12 rounded-full object-cover mr-3">
                                @else
                                <div class="w-12 h-12 bg-gray-300 dark:bg-gray-600 rounded-full mr-3 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"></path>
                                    </svg>
                                </div>
                                @endif
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $pet->name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $pet->breed }}</p>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <a href="{{ route('user.pet-care.pet.reminders', $pet) }}"
                                    class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm">
                                    View Reminders ({{ $pet->petCareReminders->where('is_completed', false)->count() }})
                                </a>
                                <a href="{{ route('user.pet-care.pet.logs', $pet) }}"
                                    class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded text-sm">
                                    View Care Logs ({{ $pet->petCareLogs->count() }})
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No pets yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding your first pet.</p>
                        <div class="mt-6">
                            <a href="{{ route('user.pets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Add Pet
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-user-layout>