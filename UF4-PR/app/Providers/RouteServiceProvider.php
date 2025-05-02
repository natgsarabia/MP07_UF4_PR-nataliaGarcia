<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Ruta a la que se redirige después del login.
     */
    public const HOME = '/home';

    /**
     * Define tus rutas aquí.
     */
    public function boot(): void
    {
        $this->routes(function () {
            // Rutas de la API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Rutas web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
