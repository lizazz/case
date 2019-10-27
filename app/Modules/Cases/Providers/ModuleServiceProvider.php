<?php

namespace App\Modules\Cases\Providers;

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
        $this->loadTranslationsFrom(module_path('cases', 'Resources/Lang', 'app'), 'cases');
        $this->loadViewsFrom(module_path('cases', 'Resources/Views', 'app'), 'cases');
        $this->loadMigrationsFrom(module_path('cases', 'Database/Migrations', 'app'), 'cases');
        $this->loadConfigsFrom(module_path('cases', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('cases', 'Database/Factories', 'app'));
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
