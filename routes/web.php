<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPetController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ShelterController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dogs', [DogAdoptionController::class, 'index'])->name('dogs.index');
Route::get('/dogs/{dog}', [DogAdoptionController::class, 'show'])->name('dogs.show');
Route::post('/dogs/{dog}/adopt', [DogAdoptionController::class, 'adopt'])->name('dogs.adopt')->middleware('auth');

// User routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-applications', [UserApplicationController::class, 'index'])->name('applications.index');

    // Pets
    Route::resource('pets', UserPetController::class)->except(['show']);
    Route::delete('pets/photos/{photo}', [UserPetController::class, 'destroyPhoto'])->name('pets.photos.destroy');

    // Dog Tinder
    Route::get('/browse-dogs', [App\Http\Controllers\DogTinderController::class, 'index'])->name('dog-tinder.index');
    Route::get('/adoption-gallery', [ShelterController::class, 'adoptionGallery'])->name('adoption-gallery');
    Route::post('/dog-tinder/swipe', [App\Http\Controllers\DogTinderController::class, 'swipe'])->name('dog-tinder.swipe');
    Route::get('/dog-tinder/notifications', [App\Http\Controllers\DogTinderController::class, 'notifications'])->name('dog-tinder.notifications');
    Route::post('/dog-tinder/notifications/{id}/read', [App\Http\Controllers\DogTinderController::class, 'markNotificationAsRead'])->name('dog-tinder.notifications.read');

    Route::get('/notifications/latest', [App\Http\Controllers\DogTinderController::class, 'latestNotifications'])->name('notifications.latest');

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
    Route::patch('/dogs/{dog}/toggle-active', [ShelterController::class, 'toggleActive'])->name('dogs.toggle-active');

    // Shelter application management
    Route::get('/applications', [ShelterController::class, 'indexApplications'])->name('applications.index');
    Route::patch('/applications/{application}', [ShelterController::class, 'updateApplication'])->name('applications.update');
    Route::get('/history', [ShelterController::class, 'applicationHistory'])->name('applications.history');
});

require __DIR__ . '/auth.php';
