<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShelterDog;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;

class ShelterDogAdoptionController extends Controller
{
    public function show(ShelterDog $shelterDog)
    {
        $shelterDog->load('photos', 'shelter', 'breed');
        return view('shelter-dogs.show', ['dog' => $shelterDog]);
    }

    public function adopt(Request $request, ShelterDog $shelterDog)
    {
        $application = AdoptionApplication::create([
            'user_id' => Auth::id(),
            'dog_id' => $shelterDog->id,
            'shelter_id' => $shelterDog->shelter_id,
            'message' => $request->message,
        ]);

        // Change the dog's status to 'pending'
        $shelterDog->update(['status' => 'pending']);

        return redirect()->route('shelter-dogs.index')->with('success', 'Your adoption application has been submitted!');
    }

    public function index()
    {
        $dogs = ShelterDog::where('status', 'available')
            ->with('breed', 'shelter')
            ->get();
        return view('shelter-dogs.index', ['dogs' => $dogs]);
    }
}
