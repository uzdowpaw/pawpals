@extends('layouts.shelter')

@section('header')
<h2 class="font-semibold text-xl text-white leading-tight">
    {{ __('Manage Dogs') }}
</h2>
@endsection

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Manage Your Dogs</h1>

    <a href="{{ route('shelter.dogs.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Dog</a>

    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Photo</th>
                    <th class="py-3 px-6 text-left">Breed</th>
                    <th class="py-3 px-6 text-center">Age</th>
                    <th class="py-3 px-6 text-center">Sex</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($dogs as $dog)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $dog->name }}</td>
                    <td class="py-3 px-6 text-left">
                        @if($dog->main_photo_path)
                        <img src="{{ url('storage/' . $dog->main_photo_path) }}" alt="{{ $dog->name }}" class="w-16 h-16 object-cover rounded-full">
                        @else
                        <img src="{{ url('storage/images/default_pet.svg') }}" alt="Default Pet" class="w-16 h-16 object-cover rounded-full">
                        @endif
                    </td>
                    <td class="py-3 px-6 text-left">{{ $dog->breed->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $dog->age }}</td>
                    <td class="py-3 px-6 text-center">{{ $dog->sex }}</td>
                    <td class="py-3 px-6 text-center">{{ $dog->status }}</td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('shelter.dogs.edit', $dog->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('shelter.dogs.destroy', $dog->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No dogs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection