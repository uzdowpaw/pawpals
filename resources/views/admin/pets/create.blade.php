<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Pet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Pet Details</h3>

                    <form method="POST" action="{{ route('admin.pets.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="breed" :value="__('Breed')" />
                            <select id="breed" name="breed" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @foreach($breeds as $breed)
                                    <option value="{{ $breed->name }}">{{ $breed->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('breed')" class="mt-2" />
                        </div>

                        <!-- Age -->
                        <div class="mt-4">
                            <x-input-label for="age" :value="__('Age')" />
                            <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age')" required />
                            <x-input-error :messages="$errors->get('age')" class="mt-2" />
                        </div>

                        <!-- Size -->
                        <div class="mt-4">
                            <x-input-label for="size" :value="__('Size')" />
                            <select id="size" name="size" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="small" {{ old('size') == 'small' ? 'selected' : '' }}>Small</option>
                                <option value="medium" {{ old('size') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="large" {{ old('size') == 'large' ? 'selected' : '' }}>Large</option>
                            </select>
                            <x-input-error :messages="$errors->get('size')" class="mt-2" />
                        </div>

                        <!-- Behavior Description -->
                        <div class="mt-4">
                            <x-input-label for="behavior_description" :value="__('Behavior Description')" />
                            <textarea id="behavior_description" name="behavior_description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('behavior_description') }}</textarea>
                            <x-input-error :messages="$errors->get('behavior_description')" class="mt-2" />
                        </div>

                        <!-- Photos -->
                        <div class="mt-4">
                            <x-input-label for="photos" :value="__('Photos (Max 2MB per photo)')" />
                            <input id="photos" class="block mt-1 w-full text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 focus:outline-none" type="file" name="photos[]" multiple accept="image/*" />
                            <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Add Pet') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>