<?php

use Illuminate\Support\Facades\Route;
use App\Models\DogMatch;
use Illuminate\Http\Request;

Route::get('/check-match', function (Request $request) {
    if (!$request->has('dog_id')) {
        return response()->json(['error' => 'Missing dog_id parameter'], 400);
    }
    
    $dogId = $request->input('dog_id');
    $userId = auth()->id();
    
    $match = DogMatch::where('user_id', $userId)
        ->where('dog_id', $dogId)
        ->first();
    
    if ($match) {
        return response()->json([
            'exists' => true,
            'match_id' => $match->id,
            'interaction_type' => $match->interaction_type,
            'created_at' => $match->created_at
        ]);
    } else {
        return response()->json(['exists' => false]);
    }
});