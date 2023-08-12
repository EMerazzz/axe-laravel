<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('AXE')
                ->group(base_path('routes/AXE.php'));
                // modulo personas
            Route::middleware('web')
                ->prefix('personas')
                ->group(base_path('routes/personas.php'));
            Route::middleware('web')
                ->prefix('telefonos')
                ->group(base_path('routes/telefonos.php'));
            Route::middleware('web')
                ->prefix('direcciones')
                ->group(base_path('routes/direcciones.php'));
            Route::middleware('web')
                ->prefix('correos')
                ->group(base_path('routes/correos.php'));
            Route::middleware('web')
                ->prefix('contacto')
                ->group(base_path('routes/contacto.php'));   
            // Modulo academico  
            Route::middleware('web')
                ->prefix('asignaturas')
                ->group(base_path('routes/asignaturas.php')); 
            // modulo docentes
            Route::middleware('web')
            ->prefix('docentes')
            ->group(base_path('routes/docentes.php'));  
            Route::middleware('web')
            ->prefix('docentesAsignatura')
            ->group(base_path('routes/docentesAsignatura.php'));  

            //Modulo estudiantes
            Route::middleware('web')
            ->prefix('padres')
            ->group(base_path('routes/padres.php')); 
            
            Route::middleware('web')
            ->prefix('estudiantes')
            ->group(base_path('routes/estudiantes.php')); 

            Route::middleware('web')
            ->prefix('login')
            ->group(base_path('routes/login.php')); 
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
