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
            Route::middleware('web')
                ->prefix('secciones')
                ->group(base_path('routes/secciones.php')); 
            Route::middleware('web')
                ->prefix('jornadas')
                ->group(base_path('routes/jornadas.php')); 
            Route::middleware('web')
                ->prefix('anio_academico')
                ->group(base_path('routes/anio_academico.php'));   
            Route::middleware('web')
                ->prefix('nivel_academico')
                ->group(base_path('routes/nivel_academico.php'));  
            // modulo docentes
            Route::middleware('web')
            ->prefix('docentes')
            ->group(base_path('routes/docentes.php'));  
            Route::middleware('web')
            ->prefix('docentesAsignatura')
            ->group(base_path('routes/docentesAsignatura.php'));  
           //modulo matricula
           Route::middleware('web')
           ->prefix('matricula')
           ->group(base_path('routes/matricula.php')); 
            //Modulo estudiantes
            Route::middleware('web')
            ->prefix('padres')
            ->group(base_path('routes/padres.php')); 

            Route::middleware('web')
            ->prefix('login')
            ->group(base_path('routes/login.php')); 
            //modulo Seguridad
            Route::middleware('web')
            ->prefix('usuarios')
            ->group(base_path('routes/usuarios.php'));
            Route::middleware('web')
            ->prefix('preguntas_usuarios')
            ->group(base_path('routes/preguntas_usuarios.php'));
            Route::middleware('web')
            ->prefix('roles')
            ->group(base_path('routes/roles.php'));
            Route::middleware('web')
            ->prefix('permisos')
            ->group(base_path('routes/permisos.php'));
            Route::middleware('web')
            ->prefix('estado_usuario')
            ->group(base_path('routes/estado_usuario.php'));
            Route::middleware('web')
            ->prefix('bitacora')
            ->group(base_path('routes/bitacora.php'));
            Route::middleware('web')
            ->prefix('preguntas')
            ->group(base_path('routes/preguntas.php'));
            Route::middleware('web')
            ->prefix('objetos')
            ->group(base_path('routes/objetos.php'));
            Route::middleware('web')
            ->prefix('parametros')
            ->group(base_path('routes/parametros.php'));
            Route::middleware('web')
            ->prefix('roles_objetos')
            ->group(base_path('routes/roles_objetos.php'));
            Route::middleware('web')
            ->prefix('estado_rol')
            ->group(base_path('routes/estado_rol.php'));
            //Reportes
            Route::middleware('web')
            ->prefix('Reportebitacora')
            ->group(base_path('routes/Rbitacora.php'));
            Route::middleware('web')
            ->prefix('Reportepersonas')
            ->group(base_path('routes/Rpersonas.php'));
            Route::middleware('web')
            ->prefix('Reportepersonas')
            ->group(base_path('routes/Rpersonas.php'));
            Route::middleware('web')
            ->prefix('Reportematriculas')
            ->group(base_path('routes/Rmatriculas.php'));
            Route::middleware('web')
            ->prefix('Reportedocentes')
            ->group(base_path('routes/Rdocentes.php'));

            Route::middleware('web')
            ->prefix('cambiarContrasena')
            ->group(base_path('routes/cambiarContrasena.php'));

            Route::middleware('web')
            ->prefix('Reportepadres')
            ->group(base_path('routes/Rpadres.php'));
            
            Route::middleware('web')
            ->prefix('backuprestore')
            ->group(base_path('routes/backuprestore.php'));

            Route::middleware('web')
            ->prefix('estudiantes')
            ->group(base_path('routes/estudiantes.php'));
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
