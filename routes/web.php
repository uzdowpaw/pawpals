<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPetController;
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


// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        // User Pet Management Routes
        Route::resource('pets', UserPetController::class)->except(['show']);
        Route::delete('pets/photos/{photo}', [UserPetController::class, 'destroyPhoto'])->name('pets.photos.destroy');
        
        // Dog Tinder routes
        Route::get('/browse-dogs', [App\Http\Controllers\DogTinderController::class, 'index'])->name('dog-tinder.index');
        Route::post('/dog-tinder/swipe', [App\Http\Controllers\DogTinderController::class, 'swipe'])->name('dog-tinder.swipe');
        Route::get('/dog-tinder/notifications', [App\Http\Controllers\DogTinderController::class, 'notifications'])->name('dog-tinder.notifications');
        Route::post('/dog-tinder/notifications/{id}/read', [App\Http\Controllers\DogTinderController::class, 'markNotificationAsRead'])->name('dog-tinder.notifications.read');
    });

require __DIR__.'/auth.php';
