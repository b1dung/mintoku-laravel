<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Policies\RolePolicy;
use App\Models\Admin;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (Admin $admin, $ability) {
            if ($admin->hasRole('super_admin')) {
                return true;
            }
            return null;
        });

        Gate::policy(\Spatie\Permission\Models\Role::class, \App\Policies\RolePolicy::class);
    }
}
