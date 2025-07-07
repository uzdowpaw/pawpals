<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Breed;
use App\Models\Photo;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Middleware is applied in the route group (web.php)
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeDogs = Dog::count();
        $newUsers = User::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $totalMatches = 0; // This would be calculated based on your matching system

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeDogs',
            'newUsers',
            'totalMatches',
            'recentUsers'
        ));
    }

    /**
     * Display a listing of users.
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,admin,shelter'],
            'email_verified' => ['boolean'],
            'send_welcome_email' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => $request->email_verified ? now() : null,
        ]);

        // Send welcome email if requested
        if ($request->send_welcome_email) {
            // You would implement the welcome email functionality here
            // Mail::to($user)->send(new WelcomeEmail($user));
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:user,admin,shelter'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroyUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Display reports page.
     */
    public function reports()
    {
        $userStats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'users' => User::where('role', 'user')->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'unverified' => User::whereNull('email_verified_at')->count(),
        ];

        $dogStats = [
            'total' => Dog::count(),
            'recent' => Dog::where('created_at', '>=', Carbon::now()->subWeek())->count(),
        ];

        $registrationData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $registrationData[] = [
                'date' => $date->format('M d'),
                'count' => User::whereDate('created_at', $date)->count()
            ];
        }

        return view('admin.reports', compact('userStats', 'dogStats', 'registrationData'));
    }

    public function pets(Request $request)
    {
        $query = Dog::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('breed', 'like', "%{$search}%");
            });
        }

        // Size filter
        if ($request->filled('size')) {
            $query->where('size', $request->get('size'));
        }

        $pets = $query->with('photos')->latest()->paginate(15);

        return view('admin.pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new pet.
     */
    public function createPet()
    {
        $breeds = Breed::orderBy('name')->get();
        return view('admin.pets.create', compact('breeds'));
    }

    /**
     * Store a newly created pet in storage.
     */
    public function storePet(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'breed' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'size' => ['required', 'in:small,medium,large'],
            'behavior_description' => ['nullable', 'string'],
            'photos.*' => ['nullable', 'image', 'max:2048'], // Max 2MB per photo
        ]);

        $dog = Dog::create([
            'user_id' => auth()->id(), // Assign to the authenticated admin user
            'name' => $request->name,
            'breed' => $request->breed,
            'age' => $request->age,
            'size' => $request->size,
            'behavior_description' => $request->behavior_description,
            'shelter_id' => null, // Explicitly set shelter_id to null
            'description' => $request->behavior_description ?? '', // Use behavior_description as description or empty string
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('dogs', 'public');
                $dog->photos()->create([
                    'path' => $path,
                    'is_main' => ($index === 0), // Set the first uploaded photo as main,
                ]);
            }
        }

        return redirect()->route('admin.pets.index')
            ->with('success', 'Pet created successfully.');
    }

    /**
     * Show the form for editing the specified pet.
     */
    public function editPet(Dog $pet)
    {
        $users = User::all(); // Fetch all users
        $breeds = Breed::orderBy('name')->get();
        return view('admin.pets.edit', compact('pet', 'users', 'breeds'));
    }

    /**
     * Update the specified pet in storage.
     */
    public function updatePet(Request $request, Dog $pet)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'breed' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'size' => ['required', 'in:small,medium,large'],
            'behavior_description' => ['nullable', 'string'],
            'photos.*' => ['nullable', 'image', 'max:2048'],
            'existing_photos_to_delete' => ['nullable', 'array'],
            'existing_photos_to_delete.*' => ['exists:photos,id'],
            'main_photo_id' => ['nullable', 'exists:photos,id'],
            'user_id' => ['nullable', 'exists:users,id'], // Add user_id validation
        ]);

        $pet->update([
            'name' => $request->name,
            'breed' => $request->breed,
            'age' => $request->age,
            'size' => $request->size,
            'behavior_description' => $request->behavior_description,
            'user_id' => $request->user_id, // Assign user_id
        ]);

        // Handle photo deletions
        if ($request->has('existing_photos_to_delete')) {
            foreach ($request->existing_photos_to_delete as $photoId) {
                $photo = Photo::find($photoId);
                if ($photo && $photo->dog_id === $pet->id) {
                    Storage::disk('public')->delete($photo->path);
                    $photo->delete();
                }
            }
        }

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('dogs', 'public');
                $pet->photos()->create(['path' => $path]);
            }
        }

        // Handle main photo selection
        if ($request->filled('main_photo_id')) {
            $pet->photos()->update(['is_main' => false]); // Unset all main photos
            $mainPhoto = Photo::find($request->main_photo_id);
            if ($mainPhoto && $mainPhoto->dog_id === $pet->id) {
                $mainPhoto->update(['is_main' => true]);
            }
        } else {
            // If no main photo is selected, ensure at least one photo is main if photos exist
            if ($pet->photos()->where('is_main', true)->doesntExist() && $pet->photos()->exists()) {
                $pet->photos()->first()->update(['is_main' => true]);
            }
        }

        return redirect()->route('admin.pets.index')
            ->with('success', 'Pet updated successfully.');
    }

    /**
     * Remove the specified pet from storage.
     */
    public function destroyPet(Dog $pet)
    {
        // Delete associated photos from storage
        foreach ($pet->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }
        $pet->photos()->delete(); // Delete photo records from database
        $pet->delete();

        return redirect()->route('admin.pets.index')
            ->with('success', 'Pet deleted successfully.');
    }

    /**
     * Display a listing of adoptions.
     */
    public function adoptions()
    {
        $adoptions = \App\Models\AdoptionApplication::with(['user', 'pet'])->latest()->paginate(15);
        return view('admin.adoptions.index', compact('adoptions'));
    }

    /**
     * Display the specified adoption.
     */
    public function showAdoption($adoptionId)
    {
        $adoption = \App\Models\AdoptionApplication::with(['user', 'pet'])->findOrFail($adoptionId);
        return view('admin.adoptions.show', compact('adoption'));
    }

    /**
     * Update the specified adoption in storage.
     */
    public function updateAdoption(Request $request, $adoptionId)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);
        
        $adoption = \App\Models\AdoptionApplication::findOrFail($adoptionId);
        $adoption->update(['status' => $request->status]);
        
        // Notify the user about the status change
        if (class_exists('\App\Notifications\AdoptionApplicationStatusUpdated')) {
            $adoption->user->notify(new \App\Notifications\AdoptionApplicationStatusUpdated($adoption));
        }
        
        return redirect()->route('admin.adoptions.index')->with('success', 'Adoption updated successfully.');
    }

    /**
     * Remove the specified adoption from storage.
     */
    public function destroyAdoption($adoptionId)
    {
        $adoption = \App\Models\AdoptionApplication::findOrFail($adoptionId);
        $adoption->delete();
        return redirect()->route('admin.adoptions.index')->with('success', 'Adoption deleted successfully.');
    }
}
