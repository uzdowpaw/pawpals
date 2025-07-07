<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl admin-text-primary leading-tight">
            {{ __('Pet Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="admin-card overflow-hidden sm:rounded-lg">
                <div class="p-6 admin-text-primary">
                    <h3 class="text-lg font-medium admin-text-primary mb-4">All Pets</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y" style="border-color: #CD5656;">
                            <thead style="background-color: #EAEBD0;">
                                <div class="flex justify-end mb-4">
                                    <a href="{{ route('admin.pets.create') }}" class="admin-btn-primary inline-flex items-center px-4 py-2 rounded-md text-sm font-medium">
                                        Add New Pet
                                    </a>
                                </div>

                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium admin-text-primary uppercase tracking-wider">Photo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium admin-text-primary uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium admin-text-primary uppercase tracking-wider">Breed</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium admin-text-primary uppercase tracking-wider">Age</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium admin-text-primary uppercase tracking-wider">Size</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium admin-text-primary uppercase ">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="admin-card divide-y" style="border-color: #CD5656;">
                                @foreach ($pets as $pet)
                                <tr class="hover:opacity-80">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium admin-text-primary">
                                        @php
                                        $mainPhoto = $pet->photos->where('is_main', true)->first();
                                        $photoPath = $mainPhoto ? $mainPhoto->path : null;
                                        @endphp

                                        @if ($photoPath)
                                        @if (Str::startsWith($photoPath, 'img/pjeski/'))
                                        <img src="{{ asset($photoPath) }}" alt="{{ $pet->name }}" class="h-16 w-16 rounded-full object-cover">
                                        @else
                                        <img src="{{ asset('storage/' . $photoPath) }}" alt="{{ $pet->name }}" class="h-16 w-16 rounded-full object-cover">
                                        @endif
                                        @else
                                        <img src="{{ asset('img/pjeski/default.jpg') }}" alt="Default Pet Image" class="h-16 w-16 rounded-full object-cover">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium admin-text-primary">{{ $pet->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm admin-text-secondary">{{ $pet->breed }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm admin-text-secondary">{{ $pet->age }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm admin-text-secondary">{{ $pet->size }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                        <a href="{{ route('admin.pets.edit', $pet->id) }}" class="admin-text-primary hover:opacity-80">Edit</a>
                                        <form action="{{ route('admin.pets.destroy', $pet->id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-text-primary hover:opacity-80" onclick="return confirm('Are you sure you want to delete this pet?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>