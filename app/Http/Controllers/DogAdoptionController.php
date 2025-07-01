<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;

class DogAdoptionController extends Controller
{
    public function show(Dog $dog)
    {
        $dog->load('photos', 'shelter');
        return view('dogs.show', ['dog' => $dog]);
    }
    public function adopt(Request $request, Dog $dog)
    {
        $application = AdoptionApplication::create([
            'user_id' => Auth::id(),
            'dog_id' => $dog->id,
            'shelter_id' => $dog->shelter_id,
            'message' => $request->message,
        ]);

        // Optionally, change the dog's status to 'pending'
        $dog->update(['status' => 'pending']);

        return redirect()->route('dogs.index')->with('success', 'Your adoption application has been submitted!');
    }

    public function index()
    {
        $dogs = Dog::where('status', 'available')->with('photos', 'shelter')->get();
        return view('dogs.index', ['dogs' => $dogs]);
    }
    //
}
