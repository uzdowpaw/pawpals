@extends('layouts.shelter')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Adoption Applications') }}
</h2>
@endsection

@section('content')
<h1 class="text-2xl font-semibold text-gray-900 mb-6">Browse Applications</h1>

<div class="shelter-card overflow-hidden">
    <table class="min-w-full">
        <thead>
            <tr style="background-color: #F3A26D;">
                <th class="px-5 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                    Applicant
                </th>
                <th class="px-5 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                    Dog
                </th>
                <th class="px-5 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                    Message
                </th>
                <th class="px-5 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                    Submitted
                </th>
                <th class="px-5 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $application)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="px-5 py-4 text-sm text-gray-900">
                    {{ $application->user->name }}
                </td>
                <td class="px-5 py-4 text-sm text-gray-900">
                    {{ $application->dog->name }}
                </td>
                <td class="px-5 py-4 text-sm text-gray-900">
                    {{ Str::limit($application->message, 50) }}
                </td>
                <td class="px-5 py-4 text-sm text-gray-900">
                    {{ $application->created_at->format('M d, Y') }}
                </td>
                <td class="px-5 py-4 text-sm">
                    <div class="flex space-x-2">
                        <form action="{{ route('shelter.applications.update', $application) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="shelter-button-secondary text-xs px-3 py-1">Approve</button>
                        </form>
                        <form action="{{ route('shelter.applications.update', $application) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded border-none font-medium transition-colors">Reject</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 text-center text-sm text-gray-500" style="background-color: #FCECDD;">
                    No applications found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection