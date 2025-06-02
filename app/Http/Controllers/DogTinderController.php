<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use App\Models\DogMatch;
use App\Notifications\MatchNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DogTinderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get dogs that the user hasn't interacted with yet
        $interactedDogIds = DogMatch::where('user_id', $user->id)->pluck('dog_id');
        
        $dogs = Dog::with(['photos', 'user'])
            ->whereNotIn('id', $interactedDogIds)
            ->where('user_id', '!=', $user->id) // Don't show user's own dogs
            ->inRandomOrder()
            ->paginate(1); // Show one dog at a time
        
        return view('user.dog-tinder.index', compact('dogs'));
    }

    public function swipe(Request $request)
    {
        $request->validate([
            'dog_id' => 'required|exists:dogs,id',
            'action' => 'required|in:like,dislike'
        ]);

        $user = Auth::user();
        $dogId = $request->dog_id;
        $action = $request->action;

        // Check if user already interacted with this dog
        $existingMatch = DogMatch::where('user_id', $user->id)
            ->where('dog_id', $dogId)
            ->first();

        if ($existingMatch) {
            return response()->json(['error' => 'Already interacted with this dog'], 400);
        }

        // Create the interaction record
        DogMatch::create([
            'user_id' => $user->id,
            'dog_id' => $dogId,
            'interaction_type' => $action
        ]);

        $isMatch = false;
        $matchedUser = null;

        // If it's a like, check for mutual match
        if ($action === 'like') {
            $dog = Dog::find($dogId);
            $dogOwnerId = $dog->user_id;

            // Check if there's a mutual match
            if (DogMatch::checkMutualMatch($user->id, $dogOwnerId)) {
                $isMatch = true;
                $matchedUser = User::find($dogOwnerId);

                    $user->notify(new MatchNotification($matchedUser, $dog));
                $matchedUser->notify(new MatchNotification($user, $dog));
            }
        }

        return response()->json([
            'success' => true,
            'is_match' => $isMatch,
            'matched_user' => $matchedUser ? $matchedUser->name : null
        ]);
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(20);

        return view('user.dog-tinder.notifications', compact('notifications'));
    }

    public function markNotificationAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->firstOrFail();

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function latestNotifications()
    {

        $user = Auth::user();
        $notifications = $user->unreadNotifications()->latest()->take(5)->get(); // Get latest 5 unread notifications

        return response()->json($notifications);
    }
}
