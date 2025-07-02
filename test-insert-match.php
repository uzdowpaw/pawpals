<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get database connection
try {
    $db = $app->make('db');
    echo "Connected to database successfully.\n";
    
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
    
    // Try to insert a record directly into the dog_matches table
    echo "Inserting record into dog_matches table...\n";
    try {
        $result = $db->table('dog_matches')->insert([
            'user_id' => $user->id,
            'dog_id' => $dog->id,
            'interaction_type' => 'like',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        echo "Insert result: " . ($result ? "Success" : "Failed") . "\n";
        
        // Verify the record was inserted
        $match = App\Models\DogMatch::where('user_id', $user->id)
            ->where('dog_id', $dog->id)
            ->first();
        
        if ($match) {
            echo "Success! Record found in database with ID: {$match->id}\n";
        } else {
            echo "Error: Record not found in database after insert\n";
        }
    } catch (Exception $e) {
        echo "Insert error: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "Database connection error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}