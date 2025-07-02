<x-user-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add Reminder for') }} {{ $pet->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation -->
            <div class="mb-6">
                <a href="{{ route('user.pet-care.pet.reminders', $pet) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    ← Back to {{ $pet->name }}'s Reminders
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Create New Reminder</h3>

                    <form action="{{ route('user.pet-care.pet.reminders.store', $pet) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Title *
                            </label>
                            <input type="text"
                                name="title"
                                id="title"
                                value="{{ old('title') }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Type *
                            </label>
                            <select name="type"
                                id="type"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select a type</option>
                                <option value="feeding" {{ old('type') === 'feeding' ? 'selected' : '' }}>Feeding</option>
                                <option value="medication" {{ old('type') === 'medication' ? 'selected' : '' }}>Medication</option>
                                <option value="grooming" {{ old('type') === 'grooming' ? 'selected' : '' }}>Grooming</option>
                                <option value="vet_visit" {{ old('type') === 'vet_visit' ? 'selected' : '' }}>Vet Visit</option>
                                <option value="exercise" {{ old('type') === 'exercise' ? 'selected' : '' }}>Exercise</option>
                                <option value="training" {{ old('type') === 'training' ? 'selected' : '' }}>Training</option>
                                <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>
                            <textarea name="description"
                                id="description"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Reminder Date -->
                        <div>
                            <label for="reminder_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Reminder Date & Time *
                            </label>
                            <input type="datetime-local"
                                name="reminder_date"
                                id="reminder_date"
                                value="{{ old('reminder_date') }}"
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('reminder_date')" class="mt-2" />
                        </div>

                        <!-- Frequency -->
                        <div>
                            <label for="frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Frequency *
                            </label>
                            <select name="frequency"
                                id="frequency"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="once" {{ old('frequency') === 'once' ? 'selected' : '' }}>Once</option>
                                <option value="daily" {{ old('frequency') === 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ old('frequency') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ old('frequency') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            </select>
                            <x-input-error :messages="$errors->get('frequency')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Note: Recurring reminders will need to be manually recreated after completion.
                            </p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-3 pt-6">
                            <a href="{{ route('user.pet-care.pet.reminders', $pet) }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Create Reminder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set default reminder date to tomorrow at 9 AM if not set
        document.addEventListener('DOMContentLoaded', function() {
            const reminderDateInput = document.getElementById('reminder_date');
            if (!reminderDateInput.value) {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                tomorrow.setHours(9, 0, 0, 0);
                reminderDateInput.value = tomorrow.toISOString().slice(0, 16);
            }
        });
    </script>
</x-user-layout>