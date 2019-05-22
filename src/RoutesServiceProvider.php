<?php

namespace RB28DETT\Routes;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use RB28DETT\Permissions\PermissionsChecker;
use RB28DETT\Routes\Models\Route;
use RB28DETT\Routes\Policies\RoutePolicy;

class RoutesServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Route::class => RoutePolicy::class,
    ];

    /**
     * The mandatory permissions for the module.
     *
     * @var array
     */
    protected $permissions = [
        [
            'name' => 'Routes Access',
            'slug' => 'rb28dett::routes.access',
            'desc' => 'Grants access to rb28dett/Routes module',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->loadViewsFrom(__DIR__.'/Views', 'rb28dett_routes');
        $this->loadTranslationsFrom(__DIR__.'/Translations', 'rb28dett_routes');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        // Make sure the permissions are OK
        PermissionsChecker::check($this->permissions);
    }

    /**
     * I cheated this comes from the AuthServiceProvider extended by the App\Providers\AuthServiceProvider.
     *
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
