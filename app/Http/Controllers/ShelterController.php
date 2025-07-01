<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShelterDog as Dog;
use App\Models\Breed;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\ShelterDog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShelterController extends Controller
{
    use AuthorizesRequests;
    public function dashboard()
    {
        $totalDogs = Dog::where('shelter_id', Auth::id())->count();
        $availableDogs = Dog::where('shelter_id', Auth::id())
            ->where('status', 'available')
            ->count();
        $adoptedDogs = Dog::where('shelter_id', Auth::id())
            ->where('status', 'adopted')
            ->count();
        $pendingApplications = AdoptionApplication::where('shelter_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        return view('shelter.dashboard', compact('totalDogs', 'availableDogs', 'adoptedDogs', 'pendingApplications'));
    }

    public function indexApplications()
    {
        $applications = AdoptionApplication::where('shelter_id', Auth::id())
            ->where('status', 'pending')
            ->with('user', 'dog')
            ->get();

        return view('shelter.applications', ['applications' => $applications]);
    }

    public function updateApplication(Request $request, AdoptionApplication $application)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        // Ensure the shelter owns this application
        if ($application->shelter_id !== Auth::id()) {
            abort(403);
        }

        $application->status = $request->status;
        $application->save();

        if ($application->status === 'approved') {
            // Update dog status to adopted
            $application->dog->status = 'adopted';
            $application->dog->save();

            // Reject other pending applications for the same dog
            AdoptionApplication::where('dog_id', $application->dog_id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        }

        return redirect()->route('shelter.applications.index')->with('success', 'Application status updated successfully.');
    }

    public function toggleActive(ShelterDog $dog)
    {
        $dog->update(['active' => !$dog->active]);
        return back();
    }

    public function adoptionGallery()
    {
        $activeDogs = ShelterDog::where('active', true)->get();
        return view('shelter.adoption-gallery', ['dogs' => $activeDogs]);
    }

    public function applicationHistory()
    {
        // Logic to fetch and display application history
        return view('shelter.history');
    }

    public function indexDogs()
    {
        $dogs = Dog::where('shelter_id', Auth::id())->with('breed')->get();
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

        if ($request->hasFile('main_photo')) {
            $dogData['main_photo_path'] = $request->file('main_photo')->store('dogs', 'public');
        }

        $dog = Dog::create($dogData);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('dogs', 'public');
                $photo = new \App\Models\Photo(['path' => $path]);
                $dog->photos()->save($photo);
            }
        }

        return redirect()->route('shelter.dogs.index')->with('success', 'Dog added successfully.');
    }

    public function editDog(Dog $dog)
    {
        $this->authorize('update', $dog);
        $breeds = Breed::all();
        return view('shelter.dogs.edit', compact('dog', 'breeds'));
    }

    public function updateDog(Request $request, Dog $dog)
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

    public function destroyDog(Dog $dog)
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
