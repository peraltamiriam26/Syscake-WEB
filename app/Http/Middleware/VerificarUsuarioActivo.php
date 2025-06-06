<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarUsuarioActivo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        // Verificar si el usuario está autenticado y su estado no es "dado de baja"
        if (!$user || isset($user->deleted_at)) {
            Auth::logout();
            // return redirect("/")->with('error', 'Tu cuenta ha sido desactivada.');
        }
        return $next($request);
    }
}
