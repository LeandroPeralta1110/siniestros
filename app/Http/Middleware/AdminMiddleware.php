<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (auth()->check()) {
            // Obtener el usuario actualmente autenticado
            $user = auth()->user();

            // Verificar si el usuario es administrador
            if (!$user instanceof User || !$user->isAdmin()) {
                // Si el usuario no es administrador, retornar una respuesta 403 (no autorizado)
                abort(403, 'Unauthorized');
            }
        } else {
            // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
            return redirect()->route('login');
        }

        // Si el usuario es administrador, continuar con la solicitud
        return $next($request);
    }
}
