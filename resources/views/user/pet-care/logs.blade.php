<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Care Logs for') }} {{ $pet->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation -->
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('pet-care.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    ← Back to Pet Care Dashboard
                </a>
                <div class="space-x-2">
                    <a href="{{ route('user.pet-care.pet.reminders', $pet) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                        View Reminders
                    </a>
                    <a href="{{ route('pet-care.pet.logs.create', $pet) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                        + Add Log Entry
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Pet Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        @if($pet->photos->isNotEmpty())
                            <img src="{{ asset('storage/' . $pet->photos->first()->photo_path) }}" 
                                 alt="{{ $pet->name }}" 
                                 class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-gray-600 text-xl">🐕</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $pet->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $pet->breed }} • {{ $pet->age }} years old</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Options -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Activity Type
                            </label>
                            <select name="type" id="type" 
                                    class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm">
                                <option value="">All Types</option>
                                <option value="feeding" {{ request('type') === 'feeding' ? 'selected' : '' }}>Feeding</option>
                                <option value="medication" {{ request('type') === 'medication' ? 'selected' : '' }}>Medication</option>
                                <option value="grooming" {{ request('type') === 'grooming' ? 'selected' : '' }}>Grooming</option>
                                <option value="vet_visit" {{ request('type') === 'vet_visit' ? 'selected' : '' }}>Vet Visit</option>
                                <option value="exercise" {{ request('type') === 'exercise' ? 'selected' : '' }}>Exercise</option>
                                <option value="training" {{ request('type') === 'training' ? 'selected' : '' }}>Training</option>
                                <option value="other" {{ request('type') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                From Date
                            </label>
                            <input type="date" name="date_from" id="date_from" 
                                   value="{{ request('date_from') }}"
                                   class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm">
                        </div>
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                To Date
                            </label>
                            <input type="date" name="date_to" id="date_to" 
                                   value="{{ request('date_to') }}"
                                   class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm">
                        </div>
                        <div>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                                Filter
                            </button>
                            <a href="{{ route('pet-care.pet.logs', $pet) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm ml-2">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Care Logs -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Care Activity Logs</h3>
                    
                    @if($logs->count() > 0)
                        <div class="space-y-4">
                            @foreach($logs as $log)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @switch($log->activity_type)
                                                        @case('feeding')
                                                            bg-green-100 text-green-800
                                                            @break
                                                        @case('medication')
                                                            bg-red-100 text-red-800
                                                            @break
                                                        @case('grooming')
                                                            bg-purple-100 text-purple-800
                                                            @break
                                                        @case('vet_visit')
                                                            bg-blue-100 text-blue-800
                                                            @break
                                                        @case('exercise')
                                                            bg-yellow-100 text-yellow-800
                                                            @break
                                                        @case('training')
                                                            bg-indigo-100 text-indigo-800
                                                            @break
                                                        @default
                                                            bg-gray-100 text-gray-800
                                                    @endswitch">
                                                    {{ ucfirst(str_replace('_', ' ', $log->activity_type)) }}
                                                </span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $log->performed_at->format('M j, Y g:i A') }}
                                                </span>
                                                @if($log->reminder)
                                                    <span class="text-xs text-blue-600 dark:text-blue-400">
                                                        (From reminder)
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-1">
                                                {{ $log->title }}
                                            </h4>
                                            
                                            @if($log->description)
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                                    {{ $log->description }}
                                                </p>
                                            @endif
                                            
                                            @if($log->notes)
                                                <div class="bg-gray-50 dark:bg-gray-700 rounded p-2 mt-2">
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        <strong>Notes:</strong> {{ $log->notes }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="ml-4">
                                            <form action="{{ route('pet-care.logs.destroy', $log) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this log entry?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($logs->hasPages())
                            <div class="mt-6">
                                {{ $logs->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 text-6xl mb-4">📝</div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                                No care logs yet
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                Start tracking {{ $pet->name }}'s care activities by adding your first log entry.
                            </p>
                            <a href="{{ route('pet-care.pet.logs.create', $pet) }}" 
                               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Add First Log Entry
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>