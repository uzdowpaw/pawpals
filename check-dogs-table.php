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

// Get the structure of the dogs table
echo "\nDogs table structure:\n";
$columns = $db->select('DESCRIBE dogs');
echo "Columns in dogs table:\n";
foreach ($columns as $column) {
    echo "- {$column->Field} ({$column->Type})" . 
         ($column->Null === 'NO' ? ' NOT NULL' : '') . 
         ($column->Key === 'PRI' ? ' PRIMARY KEY' : '') . 
         ($column->Default ? " DEFAULT '{$column->Default}'" : '') . 
         "\n";
}

// Get a sample dog record
echo "\nSample dog record:\n";
$dog = $db->table('dogs')->first();
if ($dog) {
    foreach ((array)$dog as $key => $value) {
        echo "- $key: $value\n";
    }
} else {
    echo "No dogs found in the database.\n";
}