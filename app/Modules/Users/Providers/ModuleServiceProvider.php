<?php

namespace App\Modules\Users\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('users', 'Resources/Lang', 'app'), 'users');
        $this->loadViewsFrom(module_path('users', 'Resources/Views', 'app'), 'users');
        $this->loadMigrationsFrom(module_path('users', 'Database/Migrations', 'app'), 'users');
        $this->loadConfigsFrom(module_path('users', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('users', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
