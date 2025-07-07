<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShelterDog;
use App\Models\Breed;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class ShelterController extends Controller
{
    use AuthorizesRequests;
    public function dashboard()
    {
        $totalDogs = ShelterDog::where('shelter_id', Auth::id())->count();
        $availableDogs = ShelterDog::where('shelter_id', Auth::id())
            ->where('status', 'available')
            ->count();
        $adoptedDogs = ShelterDog::where('shelter_id', Auth::id())
            ->where('status', 'adopted')
            ->count();
        $pendingApplications = AdoptionApplication::where('shelter_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        return view('shelter.dashboard', compact('totalDogs', 'availableDogs', 'adoptedDogs', 'pendingApplications'));
    }

    // Removed toggleActive method as active column is no longer used

    public function adoptionGallery()
    {
        $availableDogs = ShelterDog::where('status', 'available')
            ->with('breed', 'shelter', 'photos')
            ->get();
        return view('user.adoptions.adoption-gallery', ['dogs' => $availableDogs]);
    }

    public function indexDogs()
    {
        $dogs = ShelterDog::where('shelter_id', Auth::id())->with('breed')->get();

        if ($dogs->isEmpty()) {
            $dogs = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Rex',
                    'breed' => (object)['name' => 'German Shepherd'],
                    'age' => 3,
                    'sex' => 'male',
                    'status' => 'available',
                    'main_photo_path' => null
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Goldie',
                    'breed' => (object)['name' => 'Golden Retriever'],
                    'age' => 2,
                    'sex' => 'female',
                    'status' => 'available',
                    'main_photo_path' => null
                ]
            ]);
        }

        return view('shelter.dogs.index', compact('dogs'));
    }

    public function createDog()
    {
        $breeds = Breed::all();
        return view('shelter.dogs.create', compact('breeds'));
    }

    public function storeDog(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breed_id' => 'required|exists:breeds,id',
            'age' => 'required|integer',
            'sex' => 'required|in:male,female',
            'description' => 'required|string',
            'main_photo' => 'nullable|image|max:2048',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|max:2048',
        ]);

        $dogData = $request->only(['name', 'breed_id', 'age', 'sex', 'description']);
        $dogData['shelter_id'] = Auth::id();
        $dogData['status'] = 'available';

        if ($request->hasFile('main_photo')) {
            $dogData['main_photo_path'] = $request->file('main_photo')->store('dogs', 'public');
            Log::info('Main photo path: ' . $dogData['main_photo_path']);
        }

        $dog = ShelterDog::create($dogData);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('dogs', 'public');
                Log::info('Additional photo path: ' . $path);
                $photo = new \App\Models\Photo(['path' => $path]);
                $dog->photos()->save($photo);
            }
        }

        return redirect()->route('shelter.dogs.index')->with('success', 'Dog added successfully.');
    }

    public function editDog(ShelterDog $dog)
    {
        $this->authorize('update', $dog);
        $breeds = Breed::all();
        return view('shelter.dogs.edit', compact('dog', 'breeds'));
    }

    public function updateDog(Request $request, ShelterDog $dog)
    {
        $this->authorize('update', $dog);

        $request->validate([
            'name' => 'required|string|max:255',
            'breed_id' => 'required|exists:breeds,id',
            'age' => 'required|integer',
            'sex' => 'required|in:male,female',
            'description' => 'required|string',
            'main_photo' => 'nullable|image|max:2048',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|max:2048',
        ]);

        $dogData = $request->only(['name', 'breed_id', 'age', 'sex', 'description']);

        if ($request->hasFile('main_photo')) {
            if ($dog->main_photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($dog->main_photo_path);
            }
            $dogData['main_photo_path'] = $request->file('main_photo')->store('dogs', 'public');
        }

        $dog->update($dogData);

        if ($request->hasFile('photos')) {
            // Delete old photos
            foreach ($dog->photos as $photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->path);
                $photo->delete();
            }

            // Save new photos
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('dogs', 'public');
                $photo = new \App\Models\Photo(['path' => $path]);
                $dog->photos()->save($photo);
            }
        }

        return redirect()->route('shelter.dogs.index')->with('success', 'Dog updated successfully.');
    }

    public function destroyDog(ShelterDog $dog)
    {
        $this->authorize('delete', $dog);

        // Delete main photo
        if ($dog->main_photo_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($dog->main_photo_path);
        }

        // Delete additional photos
        foreach ($dog->photos as $photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        $dog->delete();
        return redirect()->route('shelter.dogs.index')->with('success', 'Dog deleted successfully.');
    }
}
