<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adoption Gallery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-6 text-center">Our Adoptable Dogs</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($dogs as $dog)
                        <div class="bg-gray-100 rounded-lg shadow-lg overflow-hidden transform transition duration-500 hover:scale-105">
                            <img class="w-full h-48 object-cover" src="{{ url('storage/' . $dog->main_photo_path) }}" alt="{{ $dog->name }}" onerror="this.onerror=null;this.src='{{ asset('images/default_pet.svg') }}';"> 
                            <div class="p-4">
                                <h4 class="text-xl font-semibold text-gray-800 mb-2">{{ $dog->name }}</h4>
                                <p class="text-gray-600 text-sm"><strong>Breed:</strong> {{ $dog->breed->name }}</p>
                                <p class="text-gray-600 text-sm"><strong>Age:</strong> {{ $dog->age }}</p>
                                <p class="text-gray-700 mt-2 text-sm">{{ Str::limit($dog->description, 100) }}</p>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('shelter-dogs.show', $dog) }}" class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded-full hover:bg-indigo-700 transition duration-300">
                                        Fill Adoption Form
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>