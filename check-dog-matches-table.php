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

// Get the structure of the dog_matches table
echo "\nDog matches table structure:\n";
$columns = $db->select('DESCRIBE dog_matches');
echo "Columns in dog_matches table:\n";
foreach ($columns as $column) {
    echo "- {$column->Field} ({$column->Type})" . 
         ($column->Null === 'NO' ? ' NOT NULL' : '') . 
         ($column->Key === 'PRI' ? ' PRIMARY KEY' : '') . 
         ($column->Default ? " DEFAULT '{$column->Default}'" : '') . 
         "\n";
}

// Get a sample dog_match record
echo "\nSample dog_match record:\n";
$match = $db->table('dog_matches')->first();
if ($match) {
    foreach ((array)$match as $key => $value) {
        echo "- $key: $value\n";
    }
} else {
    echo "No dog matches found in the database.\n";
}