@extends('layouts.shelter')

@section('header')
<h2 class="font-semibold text-xl text-white leading-tight">
    {{ __('Adoption Applications') }}
</h2>
    <script src="{{ asset('js/shelter-chat.js') }}"></script>
@endsection

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Browse Applications</h1>

    @if(session('success'))
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
                <th class="py-3 px-6 text-left">Message</th>
                <th class="py-3 px-6 text-center">Submitted</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @forelse ($applications as $application)
            <tr class="border-b hover:bg-gray-50" style="border-color: #FCECDD;">
                <td class="py-3 px-6 text-left">{{ $application->user->name }}</td>
                <td class="py-3 px-6 text-left">{{ $application->dog && $application->dog->name ? $application->dog->name : 'Unknown' }}</td>
                <td class="py-3 px-6 text-left">{{ Str::limit($application->message, 50) }}</td>
                <td class="py-3 px-6 text-center">{{ $application->created_at->format('M d, Y') }}</td>
                <td class="py-3 px-6 text-center">
                    <div class="flex space-x-2 justify-center">
                        <form action="{{ route('shelter.applications.update', $application->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="shelter-button-secondary px-2 py-1 rounded">Approve</button>
                        </form>
                        <form action="{{ route('shelter.applications.update', $application->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="px-2 py-1 rounded text-white" style="background-color: #dc2626; border: 1px solid #b91c1c;">Reject</button>
                        </form>
                        @if($application->status === 'approved')
                        <button 
                            type="button" 
                            class="open-chat-btn px-2 py-1 rounded text-white" 
                            style="background-color: #4CAF50; border: 1px solid #3e8e41;"
                            data-user-id="{{ $application->user_id }}"
                        >
                            Message
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4" style="background-color: #FCECDD; color: #00809D;">
                    No pending applications. When a user applies to adopt one of your dogs, you will see it here.
                </td>
            </tr>
            @endforelse
        </tbody>
        </table>
    </div>
</div>
@endsection