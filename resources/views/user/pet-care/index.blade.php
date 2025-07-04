<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #C96868;">
            {{ __('Pet Care Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded relative border-2" style="background-color: #FADFA1; border-color: #7EACB5; color: #C96868;" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Navigation Buttons -->
            @if($pets->count() > 0)
                @php($firstPet = $pets->first())
                <div class="mb-6 flex justify-end space-x-4">
                    <a href="{{ route('user.pet-care.pet.reminders.create', $firstPet) }}" class="inline-flex items-center px-4 py-2 border-2 text-sm font-medium rounded-md text-white transition-colors" style="background-color: #C96868; border-color: #C96868;" onmouseover="this.style.backgroundColor='#B85A5A'" onmouseout="this.style.backgroundColor='#C96868'">
                        Add Reminder
                    </a>
                    <a href="{{ route('user.pet-care.pet.logs.create', $firstPet) }}" class="inline-flex items-center px-4 py-2 border-2 text-sm font-medium rounded-md text-white transition-colors" style="background-color: #7EACB5; border-color: #7EACB5;" onmouseover="this.style.backgroundColor='#6E9BA3'" onmouseout="this.style.backgroundColor='#7EACB5'">
                        Add Log Entry
                    </a>
                </div>
            @endif

            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Overdue Reminders -->
                <div class="user-card overflow-hidden sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8" style="color: #C96868;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium" style="color: #C96868;">Overdue Reminders</h3>
                                <p class="text-2xl font-bold" style="color: #C96868;">{{ $overdueReminders->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Reminders -->
                <div class="user-card overflow-hidden sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8" style="color: #7EACB5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium" style="color: #C96868;">Upcoming Reminders</h3>
                                <p class="text-2xl font-bold" style="color: #7EACB5;">{{ $upcomingReminders->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pets -->
                <div class="user-card overflow-hidden sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8" style="color: #7EACB5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium" style="color: #C96868;">Your Pets</h3>
                                <p class="text-2xl font-bold" style="color: #7EACB5;">{{ $pets->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overdue Reminders Section -->
            @if($overdueReminders->count() > 0)
            <div class="user-card overflow-hidden sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4" style="color: #C96868;">⚠️ Overdue Reminders</h3>
                    <div class="space-y-3">
                        @foreach($overdueReminders as $reminder)
                        <div class="flex items-center justify-between p-4 rounded-lg border-2" style="background-color: #FADFA1; border-color: #C96868;">
                            <div class="flex-1">
                                <h4 class="font-medium" style="color: #C96868;">{{ $reminder->title }}</h4>
                                <p class="text-sm" style="color: #7EACB5;">{{ $reminder->dog->name }} • {{ $reminder->reminder_date->format('M j, Y g:i A') }}</p>
                                @if($reminder->description)
                                <p class="text-sm mt-1" style="color: #7EACB5;">{{ $reminder->description }}</p>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('user.pet-care.reminders.complete', $reminder) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-white px-3 py-1 rounded text-sm border-2 transition-colors" style="background-color: #7EACB5; border-color: #7EACB5;" onmouseover="this.style.backgroundColor='#6E9BA3'" onmouseout="this.style.backgroundColor='#7EACB5'">
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
            <div class="user-card overflow-hidden sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4" style="color: #C96868;">📅 Upcoming Reminders</h3>
                    <div class="space-y-3">
                        @foreach($upcomingReminders as $reminder)
                        <div class="flex items-center justify-between p-4 rounded-lg border-2" style="background-color: #FFF4EA; border-color: #7EACB5;">
                            <div class="flex-1">
                                <h4 class="font-medium" style="color: #C96868;">{{ $reminder->title }}</h4>
                                <p class="text-sm" style="color: #7EACB5;">{{ $reminder->dog->name }} • {{ $reminder->reminder_date->format('M j, Y g:i A') }}</p>
                                @if($reminder->description)
                                <p class="text-sm mt-1" style="color: #7EACB5;">{{ $reminder->description }}</p>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('user.pet-care.reminders.complete', $reminder) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-white px-3 py-1 rounded text-sm border-2 transition-colors" style="background-color: #7EACB5; border-color: #7EACB5;" onmouseover="this.style.backgroundColor='#6E9BA3'" onmouseout="this.style.backgroundColor='#7EACB5'">
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
            <div class="user-card overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4" style="color: #C96868;">🐕 Your Pets</h3>
                    @if($pets->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($pets as $pet)
                        <div class="border-2 rounded-lg p-4" style="border-color: #7EACB5;">
                            <div class="flex items-center mb-3">
                                @if($pet->photos->where('is_main', true)->first())
                                <img src="{{ Storage::url($pet->photos->where('is_main', true)->first()->path) }}"
                                    alt="{{ $pet->name }}"
                                    class="w-12 h-12 rounded-full object-cover mr-3">
                                @else
                                <div class="w-12 h-12 rounded-full mr-3 flex items-center justify-center" style="background-color: #FADFA1;">
                                    <svg class="w-6 h-6" style="color: #7EACB5;" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"></path>
                                    </svg>
                                </div>
                                @endif
                                <div>
                                    <h4 class="font-medium" style="color: #C96868;">{{ $pet->name }}</h4>
                                    <p class="text-sm" style="color: #7EACB5;">{{ $pet->breed }}</p>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <a href="{{ route('user.pet-care.pet.reminders', $pet) }}"
                                    class="block w-full text-center text-white px-3 py-2 rounded text-sm border-2 transition-colors" style="background-color: #C96868; border-color: #C96868;" onmouseover="this.style.backgroundColor='#B85A5A'" onmouseout="this.style.backgroundColor='#C96868'">
                                    View Reminders ({{ $pet->petCareReminders->where('is_completed', false)->count() }})
                                </a>
                                <a href="{{ route('user.pet-care.pet.logs', $pet) }}"
                                    class="block w-full text-center text-white px-3 py-2 rounded text-sm border-2 transition-colors" style="background-color: #7EACB5; border-color: #7EACB5;" onmouseover="this.style.backgroundColor='#6E9BA3'" onmouseout="this.style.backgroundColor='#7EACB5'">
                                    View Care Logs ({{ $pet->petCareLogs->count() }})
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12" style="color: #7EACB5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium" style="color: #C96868;">No pets yet</h3>
                        <p class="mt-1 text-sm" style="color: #7EACB5;">Get started by adding your first pet.</p>
                        <div class="mt-6">
                            <a href="{{ route('user.pets.create') }}" class="inline-flex items-center px-4 py-2 border-2 text-sm font-medium rounded-md text-white transition-colors" style="background-color: #C96868; border-color: #C96868;" onmouseover="this.style.backgroundColor='#B85A5A'" onmouseout="this.style.backgroundColor='#C96868'">
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