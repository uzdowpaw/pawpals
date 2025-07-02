<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

echo "Application loaded successfully\n";

// Bootstrap the app for testing
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get the database connection
$db = $app->make('db');
echo "Database connection established\n";

// Create a test user if it doesn't exist
$testUser = $db->table('users')->where('email', 'test@example.com')->first();
if (!$testUser) {
    $userId = $db->table('users')->insertGetId([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Created test user with ID: $userId\n";
} else {
    $userId = $testUser->id;
    echo "Using existing test user with ID: $userId\n";
}

// Create a test dog if it doesn't exist
$testDog = $db->table('dogs')->where('name', 'Test Dog')->first();
if (!$testDog) {
    $dogId = $db->table('dogs')->insertGetId([
        'name' => 'Test Dog',
        'breed' => 'Test Breed',
        'age' => 3,
        'size' => 'medium',
        'description' => 'A test dog for testing',
        'status' => 'available',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Created test dog with ID: $dogId\n";
} else {
    $dogId = $testDog->id;
    echo "Using existing test dog with ID: $dogId\n";
}

// Delete any existing matches for this user and dog
$deleted = $db->table('dog_matches')->where('user_id', $userId)->where('dog_id', $dogId)->delete();
echo "Deleted $deleted existing matches\n";

// Create a new application instance
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a session for the test user
echo "\nCreating session for test user...\n";
$sessionManager = $app->make('session');
$sessionDriver = $sessionManager->driver();
$sessionDriver->start();

// Generate a CSRF token
$token = $sessionDriver->token();
echo "Generated CSRF token: $token\n";

// Create a request with the test user authenticated
echo "\nCreating authenticated request...\n";
$request = Illuminate\Http\Request::create('/user/dog-tinder/swipe', 'POST', [
    'dog_id' => $dogId,
    'action' => 'like',
    '_token' => $token
]);

// Set the session on the request
$request->setLaravelSession($sessionDriver);

// Manually authenticate the user for this request
echo "Authenticating user...\n";
$guard = $app->make(Illuminate\Contracts\Auth\Guard::class);
$userModel = $app->make(App\Models\User::class)->find($userId);
if ($userModel) {
    $guard->setUser($userModel);
    echo "User authenticated successfully\n";
} else {
    echo "Failed to find user model\n";
}

// Process the request
echo "\nSending request to /user/dog-tinder/swipe...\n";
try {
    $response = $kernel->handle($request);
    
    echo "Response status: " . $response->getStatusCode() . "\n";
    echo "Response content: " . $response->getContent() . "\n";
    
    // Check if a match was created
    $match = $db->table('dog_matches')
        ->where('user_id', $userId)
        ->where('dog_id', $dogId)
        ->first();
    
    if ($match) {
        echo "\nMatch record created successfully:\n";
        echo "- User ID: {$match->user_id}\n";
        echo "- Dog ID: {$match->dog_id}\n";
        echo "- Interaction Type: {$match->interaction_type}\n";
        echo "- Created at: {$match->created_at}\n";
    } else {
        echo "\nNo match record was created in the database.\n";
    }
} catch (Exception $e) {
    echo "Error processing request: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

$kernel->terminate($request, $response);