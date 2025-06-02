<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Add New Pet</h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('user.pets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pet Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="breed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Breed</label>
                                <input type="text" name="breed" id="breed" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ old('breed') }}" required>
                                @error('breed')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Age</label>
                                <input type="number" name="age" id="age" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ old('age') }}" required>
                                @error('age')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="size" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                <select name="size" id="size" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                    <option value="">Select Size</option>
                                    <option value="small" {{ old('size') == 'small' ? 'selected' : '' }}>Small</option>
                                    <option value="medium" {{ old('size') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="large" {{ old('size') == 'large' ? 'selected' : '' }}>Large</option>
                                </select>
                                @error('size')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-full">
                                <label for="behavior_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Behavior Description</label>
                                <textarea name="behavior_description" id="behavior_description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>{{ old('behavior_description') }}</textarea>
                                @error('behavior_description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-full">
                                <label for="photos" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pet Photos</label>
                                <input type="file" name="photos[]" id="photos" class="mt-1 block w-full text-gray-900 dark:text-gray-100" multiple accept="image/*">
                                @error('photos')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('photos.*')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Add Pet
                            </button>
                            <a href="{{ route('user.pets.index') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150 dark:border-gray-600 dark:text-gray-300 dark:hover:text-gray-200">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>