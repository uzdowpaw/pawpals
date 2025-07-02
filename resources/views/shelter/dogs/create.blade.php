@extends('layouts.shelter')

@section('header')
<h2 class="font-semibold text-xl text-white leading-tight">
    {{ __('Add New Dog') }}
</h2>
@endsection

@section('content')
<h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Add a New Dog</h2>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Dog Details</h3>

                <form method="POST" action="{{ route('shelter.dogs.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mt-4">
                        <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Name</label>
                        <input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    </div>

                    <!-- Breed -->
                    <div class="mt-4">
                        <label for="breed_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Breed</label>
                        <select id="breed_id" name="breed_id" class="block mt-1 w-full" required>
                            @foreach ($breeds as $breed)
                            <option value="{{ $breed->id }}">{{ $breed->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Age -->
                    <div class="mt-4">
                        <label for="age" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Age</label>
                        <input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age')" required />
                    </div>

                    <!-- Sex -->
                    <div class="mt-4">
                        <label for="sex" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Sex</label>
                        <select id="sex" name="sex" class="block mt-1 w-full" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Description</label>
                        <textarea id="description" name="description" class="block mt-1 w-full">{{ old('description') }}</textarea>
                    </div>

                    <!-- Main Photo -->
                    <div class="mt-4">
                        <label for="main_photo" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Main Photo</label>
                        <input id="main_photo" class="block mt-1 w-full" type="file" name="main_photo" accept="image/*" />
                    </div>

                    <!-- Additional Photos -->
                    <div class="mt-4">
                        <label for="photos" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Additional Photos (up to 5)</label>
                        <input id="photos" class="block mt-1 w-full" type="file" name="photos[]" multiple accept="image/*" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Add Dog
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection