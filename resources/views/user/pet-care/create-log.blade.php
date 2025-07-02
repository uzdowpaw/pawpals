<x-user-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-200 leading-tight">
                {{ __('Add Log Entry for') }} {{ $pet->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation -->
            <div class="mb-6">
                <a href="{{ route('user.pet-care.pet.logs', $pet) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    ← Back to {{ $pet->name }}'s Care Logs
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Record Care Activity</h3>

                    <form action="{{ route('user.pet-care.pet.logs.store', $pet) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Activity Title *
                            </label>
                            <input type="text"
                                name="title"
                                id="title"
                                value="{{ old('title') }}"
                                required
                                placeholder="e.g., Morning feeding, Vet checkup, Daily walk"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Activity Type -->
                        <div>
                            <label for="activity_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Activity Type *
                            </label>
                            <select name="activity_type"
                                id="activity_type"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select activity type</option>
                                <option value="feeding" {{ old('activity_type') === 'feeding' ? 'selected' : '' }}>Feeding</option>
                                <option value="medication" {{ old('activity_type') === 'medication' ? 'selected' : '' }}>Medication</option>
                                <option value="grooming" {{ old('activity_type') === 'grooming' ? 'selected' : '' }}>Grooming</option>
                                <option value="vet_visit" {{ old('activity_type') === 'vet_visit' ? 'selected' : '' }}>Vet Visit</option>
                                <option value="exercise" {{ old('activity_type') === 'exercise' ? 'selected' : '' }}>Exercise</option>
                                <option value="training" {{ old('activity_type') === 'training' ? 'selected' : '' }}>Training</option>
                                <option value="other" {{ old('activity_type') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('activity_type')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>
                            <textarea name="description"
                                id="description"
                                rows="3"
                                placeholder="Describe what was done, any observations, etc."
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Performed At -->
                        <div>
                            <label for="performed_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Date & Time Performed *
                            </label>
                            <input type="datetime-local"
                                name="performed_at"
                                id="performed_at"
                                value="{{ old('performed_at', now()->format('Y-m-d\TH:i')) }}"
                                max="{{ now()->format('Y-m-d\TH:i') }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('performed_at')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                When was this activity performed? Cannot be in the future.
                            </p>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Additional Notes
                            </label>
                            <textarea name="notes"
                                id="notes"
                                rows="3"
                                placeholder="Any additional notes, observations, or important details"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <!-- Quick Templates -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Quick Templates</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <button type="button"
                                    onclick="fillTemplate('feeding', 'Morning Feeding', 'Fed regular kibble with treats')"
                                    class="text-left p-2 text-sm bg-white dark:bg-gray-600 rounded border hover:bg-gray-50 dark:hover:bg-gray-500">
                                    🍽️ Morning Feeding
                                </button>
                                <button type="button"
                                    onclick="fillTemplate('exercise', 'Daily Walk', 'Walked around the neighborhood')"
                                    class="text-left p-2 text-sm bg-white dark:bg-gray-600 rounded border hover:bg-gray-50 dark:hover:bg-gray-500">
                                    🚶 Daily Walk
                                </button>
                                <button type="button"
                                    onclick="fillTemplate('grooming', 'Brushing', 'Brushed coat and cleaned ears')"
                                    class="text-left p-2 text-sm bg-white dark:bg-gray-600 rounded border hover:bg-gray-50 dark:hover:bg-gray-500">
                                    ✂️ Grooming Session
                                </button>
                                <button type="button"
                                    onclick="fillTemplate('medication', 'Medication Given', 'Administered prescribed medication')"
                                    class="text-left p-2 text-sm bg-white dark:bg-gray-600 rounded border hover:bg-gray-50 dark:hover:bg-gray-500">
                                    💊 Medication
                                </button>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-3 pt-6">
                            <a href="{{ route('user.pet-care.pet.logs', $pet) }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Save Log Entry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillTemplate(type, title, description) {
            document.getElementById('activity_type').value = type;
            document.getElementById('title').value = title;
            document.getElementById('description').value = description;
        }
    </script>
</x-user-layout>