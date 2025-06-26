<?php

namespace App\Providers;

use App\Models\Dog;
use App\Models\PetCareReminder;
use App\Models\PetCareLog;
use App\Policies\DogPolicy;
use App\Policies\PetCareReminderPolicy;
use App\Policies\PetCareLogPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Dog::class => DogPolicy::class,
        PetCareReminder::class => PetCareReminderPolicy::class,
        PetCareLog::class => PetCareLogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}