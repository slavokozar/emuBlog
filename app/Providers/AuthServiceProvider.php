<?php

namespace App\Providers;

use App\Models\Resort;
use App\Models\User;
use App\Policies\ResortPolicy;
use App\Policies\UserPolicy;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Resort::class => ResortPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('resorts.book', 'ResortPolicy@book');
    }
}
