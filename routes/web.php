<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Pet Management
    Route::get('/pets', [AdminController::class, 'pets'])->name('pets.index');
    Route::get('/pets/create', [AdminController::class, 'createPet'])->name('pets.create');
    Route::post('/pets', [AdminController::class, 'storePet'])->name('pets.store');
    Route::get('/pets/{pet}/edit', [AdminController::class, 'editPet'])->name('pets.edit');
    Route::patch('/pets/{pet}', [AdminController::class, 'updatePet'])->name('pets.update');
    Route::delete('/pets/{pet}', [AdminController::class, 'destroyPet'])->name('pets.destroy');

    // Adoption Management
    Route::get('/adoptions', [AdminController::class, 'adoptions'])->name('adoptions.index');
    Route::get('/adoptions/{adoption}', [AdminController::class, 'showAdoption'])->name('adoptions.show');
    Route::patch('/adoptions/{adoption}', [AdminController::class, 'updateAdoption'])->name('adoptions.update');
    Route::delete('/adoptions/{adoption}', [AdminController::class, 'destroyAdoption'])->name('adoptions.destroy');
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});

require __DIR__.'/auth.php';
