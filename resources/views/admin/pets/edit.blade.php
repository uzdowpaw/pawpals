<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Edit Pet Details</h3>

                    <form method="POST" action="{{ route('admin.pets.update', $pet->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Name -->
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $pet->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Breed -->
                        <div class="mt-4">
                            <x-input-label for="breed" :value="__('Breed')" />
                            <x-text-input id="breed" class="block mt-1 w-full" type="text" name="breed" :value="old('breed', $pet->breed)" required />
                            <x-input-error :messages="$errors->get('breed')" class="mt-2" />
                        </div>

                        <!-- Age -->
                        <div class="mt-4">
                            <x-input-label for="age" :value="__('Age')" />
                            <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age', $pet->age)" required />
                            <x-input-error :messages="$errors->get('age')" class="mt-2" />
                        </div>

                        <!-- Size -->
                        <div class="mt-4">
                            <x-input-label for="size" :value="__('Size')" />
                            <select id="size" name="size" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="small" {{ old('size', $pet->size) == 'small' ? 'selected' : '' }}>Small</option>
                                <option value="medium" {{ old('size', $pet->size) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="large" {{ old('size', $pet->size) == 'large' ? 'selected' : '' }}>Large</option>
                            </select>
                            <x-input-error :messages="$errors->get('size')" class="mt-2" />
                        </div>

                        <!-- Behavior Description -->
                        <div class="mt-4">
                            <x-input-label for="behavior_description" :value="__('Behavior Description')" />
                            <textarea id="behavior_description" name="behavior_description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('behavior_description', $pet->behavior_description) }}</textarea>
                            <x-input-error :messages="$errors->get('behavior_description')" class="mt-2" />
                        </div>

                        <!-- Existing Photos -->
                        <div class="mt-4">
                            <x-input-label :value="__('Current Photos')" />
                            <div class="grid grid-cols-3 gap-4 mt-2">
                                @foreach($pet->photos as $photo)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $photo->path) }}" alt="Pet Photo" class="w-32 h-32 object-cover rounded-md">
                                    @if($photo->is_main)
                                        <span class="absolute top-0 right-0 bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-bl-md">Main</span>
                                    @endif
                                        <div class="absolute top-1 right-1">
                                            <input type="checkbox" name="existing_photos_to_delete[]" value="{{ $photo->id }}" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-red-600 shadow-sm focus:ring-red-500 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800">
                                            <span class="text-sm text-gray-900 dark:text-gray-100">Delete</span>
                                        </div>
                                        <div class="absolute bottom-1 left-1">
                                            <input type="radio" name="main_photo_id" value="{{ $photo->id }}" {{ $photo->is_main ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                            <span class="text-sm text-gray-900 dark:text-gray-100">Main</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('existing_photos_to_delete')" class="mt-2" />
                            <x-input-error :messages="$errors->get('main_photo_id')" class="mt-2" />
                        </div>

                        <!-- New Photos -->
                        <div class="mt-4">
                            <x-input-label for="photos" :value="__('Add New Photos (Max 2MB per photo)')" />
                            <input id="photos" class="block mt-1 w-full text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 focus:outline-none" type="file" name="photos[]" multiple accept="image/*" />
                            <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Pet') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>