<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // Importa la fachada Gate
use App\Models\User; // <-- ¡¡¡ASEGÚRATE DE QUE ESTA LÍNEA ESTÉ AQUÍ!!!
use App\Models\Escritor;
use App\Models\Receta;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        // Define el Gate 'create-receta'
        Gate::define('create-receta', function ($user) { // <-- ¡CORRECCIÓN AQUÍ!
            // Asegúrate de que el usuario exista y tenga un ID
            if (!$user || !$user->id) {
                return false;
            }
            // Consulta directamente si existe un registro en la tabla 'escritors'
            // con el 'usuario_id' igual al ID del usuario autenticado.
            return Escritor::where('usuario_id', $user->id)->exists();
        });

        Gate::define('update-receta', function ($user, Receta $receta) { // <-- ¡CORRECCIÓN AQUÍ!
            // Por ejemplo, solo el escritor original puede modificar su receta
            return $user->id === $receta->escritor_usuario_id;
        });

        Gate::define('delete-receta', function ($user, Receta $receta) { // <-- ¡CORRECCIÓN AQUÍ!
            // Similar, solo el escritor o un admin
            return $user->id === $receta->escritor_usuario_id; // || $user->isAdmin();
        });
    }
}