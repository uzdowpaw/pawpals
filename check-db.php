<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get database connection
try {
    $db = $app->make('db');
    echo "Connected to database successfully.\n";
    
    // Check if dog_matches table exists
    $tables = $db->select('SHOW TABLES');
    echo "Tables in database:\n";
    foreach ($tables as $table) {
        $tableName = reset($table); // Get the first value from the object
        echo "- {$tableName}\n";
        
        if ($tableName === 'dog_matches') {
            // Show the structure of dog_matches table
            echo "\nStructure of dog_matches table:\n";
            $columns = $db->select('DESCRIBE dog_matches');
            foreach ($columns as $column) {
                echo "- {$column->Field} ({$column->Type})" . 
                     ($column->Key ? " [Key: {$column->Key}]" : "") . 
                     ($column->Null === 'NO' ? " [NOT NULL]" : "") . 
                     "\n";
            }
            
            // Count records in dog_matches table
            $count = $db->table('dog_matches')->count();
            echo "\nNumber of records in dog_matches table: {$count}\n";
        }
    }
    
} catch (Exception $e) {
    echo "Database connection error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}