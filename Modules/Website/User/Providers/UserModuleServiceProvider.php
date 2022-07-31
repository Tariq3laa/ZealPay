<?php

namespace Modules\Website\User\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Website\User\Repositories\AuthRepository;
use Modules\Website\User\Repositories\AuthRepositoryInterface;

class UserModuleServiceProvider extends ServiceProvider
{

    protected $moduleNamespace = 'Modules\Website\User\Http\Controllers';
    protected $webRoute = 'Modules/Website/User/Routes/web.php';
    protected $apiRoute = 'Modules/Website/User/Routes/api.php';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerApiRoutes();
        $this->registerMigrations();
    }


    protected function registerRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(base_path($this->webRoute));
    }

    protected function registerApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(base_path($this->apiRoute));
    }

    /**
     * Register module migrations.
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    public function register()
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(BabyRepositoryInterface::class, BabyRepository::class);
        $this->app->bind(PartnerRepositoryInterface::class, PartnerRepository::class);
    }
}
