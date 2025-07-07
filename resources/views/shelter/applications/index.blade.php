@extends('layouts.shelter')

@section('header')
<h2 class="font-semibold text-xl text-white leading-tight">
    {{ __('Adoption Applications') }}
</h2>
@endsection

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Browse Applications</h1>

    @if (session('success'))
    <div class="p-4 rounded mb-4" style="background-color: #FCECDD; color: #00809D; border: 1px solid #F3A26D;">
        {{ session('success') }}
    </div>
    @endif

    <div class="shelter-card my-6">
        <table class="min-w-full table-auto">
        <thead>
            <tr style="background-color: #F3A26D; color: white;" class="uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Applicant</th>
                <th class="py-3 px-6 text-left">Dog</th>
                <th class="py-3 px-6 text-left">Status</th>
                <th class="py-3 px-6 text-center">Submitted At</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @forelse ($applications as $application)
                <tr class="border-b hover:bg-gray-50" style="border-color: #FCECDD;">
                    <td class="py-3 px-6 text-left">{{ $application->user->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $application->shelterDog && $application->shelterDog->dog ? $application->shelterDog->dog->name : 'Unknown' }}</td>
                    <td class="py-3 px-6 text-left">{{ ucfirst($application->status) }}</td>
                    <td class="py-3 px-6 text-center">{{ $application->created_at->format('M d, Y') }}</td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('shelter.applications.show', $application) }}" class="shelter-button-secondary px-2 py-1 rounded">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4" style="background-color: #FCECDD; color: #00809D;">
                        No pending applications found. When a user applies to adopt one of your dogs, you will see it here.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection