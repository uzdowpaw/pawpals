<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AdoptionApplicationStatusUpdated;

class AdoptionApplicationController extends Controller
{
    public function index()
    {
        $shelter = Auth::user();
        $applications = AdoptionApplication::whereHas('shelterDog', function ($query) use ($shelter) {
            $query->where('shelter_id', $shelter->id);
        })->with(['user', 'shelterDog'])->get();

        return view('shelter.applications.index', compact('applications'));
    }

    public function update(Request $request, AdoptionApplication $application)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $application->update(['status' => $request->status]);

        $application->user->notify(new AdoptionApplicationStatusUpdated($application));
        
        // If application is approved, create a conversation between shelter and user
        if ($request->status === 'approved') {
            // Create a conversation between the shelter and the user
            $conversation = \App\Models\Conversation::create([
                'is_group' => false,
            ]);
            
            // Attach both users to the conversation
            $conversation->users()->attach([$application->shelter_id, $application->user_id]);
        }

        return back()->with('success', 'Application status updated successfully.');
    }

    public function show(AdoptionApplication $application)
    {
        $application->load(['user', 'shelterDog', 'shelterDog.photos']);
        return view('shelter.applications.show', compact('application'));
    }

    public function history()
    {
        $shelter = Auth::user();
        $applications = AdoptionApplication::whereHas('shelterDog', function ($query) use ($shelter) {
            $query->where('shelter_id', $shelter->id);
        })->whereIn('status', ['approved', 'rejected'])->with(['user', 'shelterDog'])->get();

        return view('shelter.applications.history', compact('applications'));
    }
}