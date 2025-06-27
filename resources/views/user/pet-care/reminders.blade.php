<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Reminders for') }} {{ $pet->name }}
            </h2>
            <a href="{{ route('user.pet-care.pet.reminders.create', $pet) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Add Reminder
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Navigation -->
            <!-- Navigation -->
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('user.pet-care.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    ← Back to Pet Care Dashboard
                </a>
                <div class="space-x-2">
                    <a href="{{ route('user.pet-care.pet.logs', $pet) }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                        View Care Logs
                    </a>
                </div>
            </div>

            <!-- Pet Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center">
                        @if($pet->photos->where('is_main', true)->first())
                        <img src="{{ Storage::url($pet->photos->where('is_main', true)->first()->path) }}"
                            alt="{{ $pet->name }}"
                            class="w-16 h-16 rounded-full object-cover mr-4">
                        @else
                        <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-full mr-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"></path>
                            </svg>
                        </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $pet->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $pet->breed }} • {{ $pet->age }} years old • {{ ucfirst($pet->size) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reminders -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Care Reminders</h3>

                    @if($reminders->count() > 0)
                    <div class="space-y-4">
                        @foreach($reminders as $reminder)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 
                                    {{ $reminder->isOverdue() ? 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800' : '' }}
                                    {{ $reminder->is_completed ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' : '' }}">

                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $reminder->title }}</h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $reminder->type === 'feeding' ? 'bg-orange-100 text-orange-800' : '' }}
                                                    {{ $reminder->type === 'medication' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ $reminder->type === 'grooming' ? 'bg-purple-100 text-purple-800' : '' }}
                                                    {{ $reminder->type === 'vet_visit' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $reminder->type === 'exercise' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $reminder->type === 'training' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $reminder->type === 'other' ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $reminder->type)) }}
                                        </span>
                                        @if($reminder->frequency !== 'once')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($reminder->frequency) }}
                                        </span>
                                        @endif
                                        @if($reminder->is_completed)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            ✓ Completed
                                        </span>
                                        @elseif($reminder->isOverdue())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            ⚠️ Overdue
                                        </span>
                                        @endif
                                    </div>

                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        <strong>Due:</strong> {{ $reminder->reminder_date->format('M j, Y g:i A') }}
                                        @if($reminder->isOverdue() && !$reminder->is_completed)
                                        <span class="text-red-600">({{ $reminder->reminder_date->diffForHumans() }})</span>
                                        @elseif(!$reminder->is_completed)
                                        <span class="text-gray-500">({{ $reminder->reminder_date->diffForHumans() }})</span>
                                        @endif
                                    </p>

                                    @if($reminder->description)
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">{{ $reminder->description }}</p>
                                    @endif

                                    @if($reminder->is_completed && $reminder->completed_at)
                                    <p class="text-sm text-green-600 dark:text-green-400">
                                        <strong>Completed:</strong> {{ $reminder->completed_at->format('M j, Y g:i A') }}
                                    </p>
                                    @if($reminder->notes)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        <strong>Notes:</strong> {{ $reminder->notes }}
                                    </p>
                                    @endif
                                    @endif
                                </div>

                                <div class="flex space-x-2 ml-4">
                                    @if(!$reminder->is_completed)
                                    <form action="{{ route('pet-care.reminders.complete', $reminder) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                            Mark Complete
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('pet-care.reminders.delete', $reminder) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this reminder?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $reminders->links() }}
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No reminders yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first care reminder for {{ $pet->name }}.</p>
                        <div class="mt-6">
                            <a href="{{ route('user.pet-care.pet.reminders.create', $pet) }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Add Reminder
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>