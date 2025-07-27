<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPetController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\DogTinderController;
use App\Http\Controllers\AdoptionApplicationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect('/admin/dashboard');
    } elseif (auth()->user()->role === 'shelter') {
        return redirect('/shelter/dashboard');
    } else {
        return redirect('/user/dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chat routes
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/users', [ChatController::class, 'getUsers'])->name('users');
        Route::get('/conversations', [ChatController::class, 'getConversations'])->name('conversations');
        Route::post('/conversations', [ChatController::class, 'getOrCreateConversation'])->name('conversations.create');
        Route::get('/conversations/{conversation}/messages', [ChatController::class, 'getMessages'])->name('messages');
        Route::post('/conversations/{conversation}/messages', [ChatController::class, 'sendMessage'])->name('messages.send');
        Route::post('/conversations/{conversation}/read', [ChatController::class, 'markAsRead'])->name('messages.read');
    });
});
// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Pets
    Route::get('/pets', [AdminController::class, 'pets'])->name('pets.index');
    Route::get('/pets/create', [AdminController::class, 'createPet'])->name('pets.create');
    Route::post('/pets', [AdminController::class, 'storePet'])->name('pets.store');
    Route::get('/pets/{pet}/edit', [AdminController::class, 'editPet'])->name('pets.edit');
    Route::patch('/pets/{pet}', [AdminController::class, 'updatePet'])->name('pets.update');
    Route::delete('/pets/{pet}', [AdminController::class, 'destroyPet'])->name('pets.destroy');

    // Adoptions
    Route::get('/adoptions', [AdminController::class, 'adoptions'])->name('adoptions.index');
    Route::get('/adoptions/{adoption}', [AdminController::class, 'showAdoption'])->name('adoptions.show');
    Route::patch('/adoptions/{adoption}', [AdminController::class, 'updateAdoption'])->name('adoptions.update');
    Route::delete('/adoptions/{adoption}', [AdminController::class, 'destroyAdoption'])->name('adoptions.destroy');

    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});

// Original dog adoption routes (keep these for backward compatibility)
// Commented out until DogAdoptionController is implemented
// Route::get('/dogs', [DogAdoptionController::class, 'index'])->name('dogs.index');
// Route::get('/dogs/{dog}', [DogAdoptionController::class, 'show'])->name('dogs.show');
// Route::post('/dogs/{dog}/adopt', [DogAdoptionController::class, 'adopt'])->name('dogs.adopt')->middleware('auth');

// Shelter dog adoption routes
use App\Http\Controllers\ShelterDogAdoptionController;

Route::get('/shelter-dogs', [ShelterDogAdoptionController::class, 'index'])->name('shelter-dogs.index');
Route::get('/shelter-dogs/{shelterDog}', [ShelterDogAdoptionController::class, 'show'])->name('shelter-dogs.show');
Route::post('/shelter-dogs/{shelterDog}/adopt', [ShelterDogAdoptionController::class, 'adopt'])->name('shelter-dogs.adopt')->middleware('auth');

// User routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-applications', [App\Http\Controllers\UserApplicationController::class, 'index'])->name('applications.index');

    // Pets
    Route::resource('pets', UserPetController::class)->except(['show']);
    Route::delete('pets/photos/{photo}', [UserPetController::class, 'destroyPhoto'])->name('pets.photos.destroy');

    // Connect Users
    Route::get('/browse-dogs', [DogTinderController::class, 'index'])->name('dog-tinder.index');
    Route::get('/adoptions/adoption-gallery', [ShelterController::class, 'adoptionGallery'])->name('adoption-gallery');
    Route::post('/dog-tinder/swipe', [DogTinderController::class, 'swipe'])->name('dog-tinder.swipe');
    Route::get('/dog-tinder/notifications', [DogTinderController::class, 'notifications'])->name('dog-tinder.notifications');
    Route::post('/dog-tinder/notifications/{id}/read', [DogTinderController::class, 'markNotificationAsRead'])->name('dog-tinder.notifications.read');

    Route::get('/notifications/latest', [DogTinderController::class, 'latestNotifications'])->name('notifications.latest');

    // Pet Care Routes
    Route::prefix('pet-care')->name('pet-care.')->group(function () {
        Route::get('/', [App\Http\Controllers\PetCareController::class, 'index'])->name('index');

        // General Reminder and Log Creation Routes
        Route::get('/reminders/create', [App\Http\Controllers\PetCareController::class, 'createReminder'])->name('reminders.create');
        Route::post('/reminders', [App\Http\Controllers\PetCareController::class, 'storeReminder'])->name('reminders.store');

        Route::get('/logs/create', [App\Http\Controllers\PetCareController::class, 'createLog'])->name('logs.create');
        Route::post('/logs', [App\Http\Controllers\PetCareController::class, 'storeLog'])->name('logs.store');

        // Pet-specific routes
        Route::get('/pets/{pet}/reminders', [App\Http\Controllers\PetCareController::class, 'petReminders'])->name('pet.reminders');
        Route::get('/pets/{pet}/reminders/create', [App\Http\Controllers\PetCareController::class, 'createReminder'])->name('pet.reminders.create');
        Route::post('/pets/{pet}/reminders', [App\Http\Controllers\PetCareController::class, 'storeReminder'])->name('pet.reminders.store');

        Route::get('/pets/{pet}/logs', [App\Http\Controllers\PetCareController::class, 'petLogs'])->name('pet.logs');
        Route::get('/pets/{pet}/logs/create', [App\Http\Controllers\PetCareController::class, 'createLog'])->name('pet.logs.create');
        Route::post('/pets/{pet}/logs', [App\Http\Controllers\PetCareController::class, 'storeLog'])->name('pet.logs.store');

        // Reminder actions
        Route::patch('/reminders/{reminder}/complete', [App\Http\Controllers\PetCareController::class, 'completeReminder'])->name('reminders.complete');
        Route::delete('/reminders/{reminder}', [App\Http\Controllers\PetCareController::class, 'deleteReminder'])->name('reminders.delete');

        // Log actions
        Route::delete('/logs/{log}', [App\Http\Controllers\PetCareController::class, 'deleteLog'])->name('logs.delete');
    });
});

// Shelter routes
Route::middleware(['auth', 'shelter'])->prefix('shelter')->name('shelter.')->group(function () {
    Route::get('/dashboard', [ShelterController::class, 'dashboard'])->name('dashboard');

    // Shelter dog management
    Route::get('/dogs', [ShelterController::class, 'indexDogs'])->name('dogs.index');
    Route::get('/dogs/create', [ShelterController::class, 'createDog'])->name('dogs.create');
    Route::post('/dogs', [ShelterController::class, 'storeDog'])->name('dogs.store');
    Route::get('/dogs/{dog}/edit', [ShelterController::class, 'editDog'])->name('dogs.edit');
    Route::put('/dogs/{dog}', [ShelterController::class, 'updateDog'])->name('dogs.update');
    Route::delete('/dogs/{dog}', [ShelterController::class, 'destroyDog'])->name('dogs.destroy');

    // Shelter application management
    Route::get('/applications', [AdoptionApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [AdoptionApplicationController::class, 'show'])->name('applications.show');
    Route::patch('/applications/{application}', [AdoptionApplicationController::class, 'update'])->name('applications.update');
    Route::get('/history', [AdoptionApplicationController::class, 'history'])->name('applications.history');
});

// Route to serve images from storage/app/public
Route::get('/storage/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->where('filename', '.*');

require __DIR__ . '/auth.php';
require __DIR__ . '/check-match.php';
