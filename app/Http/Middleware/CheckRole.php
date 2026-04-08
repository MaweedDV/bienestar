<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
         if (!Auth::check()) {
            return redirect('/login'); // Redirige si no está autenticado
        }

        if (Auth::user()->role !== $role) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
            // o return redirect('/'); si prefieres redirigir en lugar de abortar
        }

        return $next($request);
    }
}
