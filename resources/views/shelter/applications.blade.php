@extends('layouts.shelter')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Adoption Applications') }}
</h2>
@endsection

@section('content')
<h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Browse Applications</h1>

<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                    Applicant
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                    Dog
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                    Message
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                    Submitted
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $application)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                    <p class="text-gray-900 dark:text-white whitespace-no-wrap">{{ $application->user->name }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                    <p class="text-gray-900 dark:text-white whitespace-no-wrap">{{ $application->dog->name }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                    <p class="text-gray-900 dark:text-white whitespace-no-wrap">{{ $application->message }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                    <p class="text-gray-900 dark:text-white whitespace-no-wrap">{{ $application->created_at->format('M d, Y') }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-right">
                    <form action="{{ route('shelter.applications.update', $application) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                    </form>
                    <form action="{{ route('shelter.applications.update', $application) }}" method="POST" class="inline-block ml-4">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-center text-sm">
                    <p class="text-gray-900 dark:text-white whitespace-no-wrap">No pending applications found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection