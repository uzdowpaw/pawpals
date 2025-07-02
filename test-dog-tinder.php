<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Get the DogTinderController instance
$controller = $app->make(App\Http\Controllers\DogTinderController::class);

// Create a test user if needed
echo "Checking for test user...\n";
$user = App\Models\User::where('email', 'test@example.com')->first();
if (!$user) {
    echo "Creating test user...\n";
    $user = new App\Models\User();
    $user->name = 'Test User';
    $user->email = 'test@example.com';
    $user->password = bcrypt('password');
    $user->role = 'user';
    $user->save();
}

// Create a test dog if needed
echo "Checking for test dog...\n";
$dog = App\Models\Dog::first();
if (!$dog) {
    echo "Creating test dog...\n";
    $dog = new App\Models\Dog();
    $dog->name = 'Test Dog';
    $dog->breed = 'Mixed';
    $dog->age = 3;
    $dog->size = 'medium';
    $dog->description = 'A test dog';
    $dog->user_id = $user->id;
    $dog->save();
}

// Delete any existing matches for this user and dog
echo "Deleting any existing matches...\n";
App\Models\DogMatch::where('user_id', $user->id)
    ->where('dog_id', $dog->id)
    ->delete();

// Create a request object
$request = new Illuminate\Http\Request();
$request->merge([
    'dog_id' => $dog->id,
    'action' => 'like'
]);

// Set the authenticated user
auth()->login($user);

// Call the swipe method
echo "Calling swipe method with dog_id: {$dog->id}, action: like\n";
try {
    $response = $controller->swipe($request);
    echo "Response: " . $response->getContent() . "\n";
    
    // Check if the match was created in the database
    $match = App\Models\DogMatch::where('user_id', $user->id)
        ->where('dog_id', $dog->id)
        ->first();
    
    if ($match) {
        echo "Success! Match created in database with interaction_type: {$match->interaction_type}\n";
    } else {
        echo "Error: Match not created in database\n";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}