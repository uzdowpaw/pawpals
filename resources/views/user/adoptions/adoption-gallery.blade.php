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
                        <div class="bg-gray-100 rounded-lg shadow-lg overflow-hidden transform transition duration-500 hover:scale-105 cursor-pointer"
                            onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'dog-{{ $dog->id }}' }))">
                            <img class="w-full h-64 object-cover" src="{{ url('storage/' . $dog->main_photo_path) }}" alt="{{ $dog->name }}" onerror="this.onerror=null;this.src='{{ asset('images/default_pet.svg') }}';">
                            <div class="p-4">
                                <h4 class="text-xl font-semibold text-gray-800 mb-2">{{ $dog->name }}</h4>
                                <p class="text-gray-600 text-sm"><strong>Breed:</strong> {{ $dog->breed->name }}</p>
                                <p class="text-gray-600 text-sm"><strong>Age:</strong> {{ $dog->age }}</p>
                                <p class="text-gray-700 mt-2 text-sm">{{ Str::limit($dog->description, 100) }}</p>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('shelter-dogs.show', $dog) }}" class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded-full hover:bg-indigo-700 transition duration-300" onclick="event.stopPropagation();">
                                        Fill Adoption Form
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for dog details -->
                        <x-modal name="dog-{{ $dog->id }}" maxWidth="2xl">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <!-- Photo gallery -->
                                    <div class="md:w-1/2">
                                        <div class="flex flex-row md:flex-row gap-4">
                                            <!-- Thumbnails on left -->
                                            <div class="w-1/4">
                                                <div class="space-y-2">
                                                    <!-- Main photo thumbnail -->
                                                    <div class="bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition" 
                                                         onmouseover="document.getElementById('main-photo-{{ $dog->id }}').src = '{{ url('storage/' . $dog->main_photo_path) }}'">
                                                        <img class="w-full h-20 object-cover" src="{{ url('storage/' . $dog->main_photo_path) }}" alt="{{ $dog->name }}" onerror="this.onerror=null;this.src='{{ asset('images/default_pet.svg') }}';">
                                                        <!-- Debug info for main photo path -->
                                                        <div class="text-xs text-gray-500 p-1 hidden">Path: {{ $dog->main_photo_path }}</div>
                                                    </div>
                                                    
                                                    <!-- Additional photos thumbnails -->
                                                    @if($dog->photos->count() > 0)
                                                        @foreach($dog->photos as $photo)
                                                        <div class="bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition"
                                                             onmouseover="document.getElementById('main-photo-{{ $dog->id }}').src = '{{ url('storage/' . $photo->path) }}'">
                                                            <img class="w-full h-20 object-cover" src="{{ url('storage/' . $photo->path) }}" alt="{{ $dog->name }}">
                                                        </div>
                                                        @endforeach
                                                    @else
                                                        <!-- Display a message when no additional photos are available -->
                                                        <div class="text-center text-gray-500 text-xs mt-2">
                                                            No additional photos
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Main photo on right -->
                                            <div class="w-3/4">
                                                <div class="bg-gray-100 rounded-lg">
                                                    <img id="main-photo-{{ $dog->id }}" class="w-full h-96 object-cover" src="{{ url('storage/' . $dog->main_photo_path) }}" alt="{{ $dog->name }}" onerror="this.onerror=null;this.src='{{ asset('images/default_pet.svg') }}';">                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dog details -->
                                    <div class="md:w-1/2">
                                        <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $dog->name }}</h2>
                                        <!-- Debug info -->
                                        <div class="text-xs text-gray-500 mb-2">Photo count: {{ $dog->photos->count() }}</div>
                                        <div class="space-y-3">
                                            <p class="text-gray-700"><span class="font-semibold">Breed:</span> {{ $dog->breed->name }}</p>
                                            <p class="text-gray-700"><span class="font-semibold">Age:</span> {{ $dog->age }} years</p>
                                            <p class="text-gray-700"><span class="font-semibold">Sex:</span> {{ ucfirst($dog->sex) }}</p>
                                            <div class="mt-4">
                                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Description</h3>
                                                <p class="text-gray-700">{{ $dog->description }}</p>
                                            </div>
                                            <div class="mt-6">
                                                <a href="{{ route('shelter-dogs.show', $dog) }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
                                                    Fill Adoption Form
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6 text-right">
                                    <button type="button" class="text-gray-500 hover:text-gray-700" @click="show = false">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </x-modal>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>