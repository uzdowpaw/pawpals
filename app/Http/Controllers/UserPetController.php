<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserPetController extends Controller
{
    /**
     * Display a listing of the user's pets.
     */
    public function index()
    {
        $user = Auth::user();
        $pets = $user->dogs()->paginate(10);
        return view('user.pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new pet.
     */
    public function create()
    {
        return view('user.pets.create');
    }

    /**
     * Store a newly created pet in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'size' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $pet = Auth::user()->dogs()->create($request->except(['photos', 'main_photo']));

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('photos', 'public');
                $isMain = ($index == $request->input('main_photo'));
                $pet->photos()->create([
                    'path' => $path,
                    'is_main' => $isMain,
                ]);
            }
        }

        return redirect()->route('user.pets.index')->with('success', 'Pet added successfully!');
    }

    /**
     * Display the specified pet.
     */
    public function show(Dog $pet)
    {
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }
        return view('user.pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified pet.
     */
    public function edit(Dog $pet)
    {
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }
        return view('user.pets.edit', compact('pet'));
    }

    /**
     * Update the specified pet in storage.
     */
    public function update(Request $request, Dog $pet)
    {
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'size' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $pet->update($request->except(['photos', 'main_photo', 'existing_photos', 'removed_photos']));

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('photos', 'public');
                $pet->photos()->create([
                    'path' => $path,
                    'is_main' => false, // Will be updated later if it's the main photo
                ]);
            }
        }

        // Handle removed photos
        if ($request->has('removed_photos')) {
            foreach ($request->input('removed_photos') as $photoId) {
                $photo = $pet->photos()->find($photoId);
                if ($photo) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->path);
                    $photo->delete();
                }
            }
        }

        // Update main photo status
        if ($request->has('main_photo')) {
            $pet->photos()->update(['is_main' => false]); // Set all to false first
            $mainPhotoId = $request->input('main_photo');
            $newMainPhoto = $pet->photos()->find($mainPhotoId);
            if ($newMainPhoto) {
                $newMainPhoto->update(['is_main' => true]);
            }
        } else {
            // If no main photo is selected, ensure one is set if photos exist
            if ($pet->photos()->where('is_main', true)->doesntExist() && $pet->photos()->exists()) {
                $pet->photos()->first()->update(['is_main' => true]);
            }
        }

        return redirect()->route('user.pets.index')->with('success', 'Pet updated successfully!');
    }

    /**
     * Remove the specified pet from storage.
     */
    public function destroy(Dog $pet)
    {
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }
        $pet->delete();
        return redirect()->route('user.pets.index')->with('success', 'Pet deleted successfully!');
    }
}
