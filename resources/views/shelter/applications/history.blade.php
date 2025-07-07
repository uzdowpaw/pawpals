@extends('layouts.shelter')

@section('content')
<div class="container">
    <h1>Application History</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Applicant</th>
                <th>Dog</th>
                <th>Status</th>
                <th>Date Processed</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $application)
                <tr>
                    <td>{{ $application->user->name }}</td>
                    <td>{{ $application->shelterDog && $application->shelterDog->dog ? $application->shelterDog->dog->name : 'Unknown' }}</td>
                    <td>{{ ucfirst($application->status) }}</td>
                    <td>{{ $application->updated_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No application history found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection