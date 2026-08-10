<?php

namespace App\Providers;

use App\Enums\Permission;
use App\Support\Tenancy\CurrentCompany;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(CurrentCompany::class, function ($app) {
            return new CurrentCompany($app['session.store']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach (Permission::cases() as $permission) {
            Gate::define($permission->value, function ($user) use ($permission): bool {
                return $user->hasPermission($permission);
            });
        }
    }
}
