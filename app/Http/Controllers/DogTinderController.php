<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use App\Models\DogMatch;
use App\Models\Notification;
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

                // Create notifications for both users
                $this->createMatchNotifications($user, $matchedUser, $dog);
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
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.dog-tinder.notifications', compact('notifications'));
    }

    public function markNotificationAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    private function createMatchNotifications($user1, $user2, $dog)
    {
        // Notification for user1 (the one who just liked)
        Notification::create([
            'user_id' => $user1->id,
            'type' => 'match',
            'data' => [
                'message' => "It's a match! You and {$user2->name} liked each other's dogs!",
                'matched_user_id' => $user2->id,
                'matched_user_name' => $user2->name,
                'dog_id' => $dog->id,
                'dog_name' => $dog->name
            ]
        ]);

        // Notification for user2 (the dog owner)
        Notification::create([
            'user_id' => $user2->id,
            'type' => 'match',
            'data' => [
                'message' => "It's a match! You and {$user1->name} liked each other's dogs!",
                'matched_user_id' => $user1->id,
                'matched_user_name' => $user1->name,
                'dog_id' => $dog->id,
                'dog_name' => $dog->name
            ]
        ]);
    }
}
