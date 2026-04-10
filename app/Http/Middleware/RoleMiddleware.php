<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $userRole = $user->role;

        // Verificar si el usuario está activo
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Tu cuenta está desactivada. Contacta al administrador.'
            ]);
        }

        // Convertir los roles a array si viene como string separado por comas
        if (count($roles) === 1 && str_contains($roles[0], ',')) {
            $roles = explode(',', $roles[0]);
        }

        // Limpiar espacios en blanco de los roles
        $roles = array_map('trim', $roles);

        // Verificar si el usuario tiene alguno de los roles permitidos
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Si no tiene el rol adecuado, redirigir según el rol actual
        switch ($userRole) {
            case 'director':
                return redirect('/director/dashboard');
            case 'teacher':
            case 'profesor':
            case 'admin':
                return redirect('/teacher/dashboard'); // CORREGIDO: era /dashboard
            case 'student':
                return redirect('/students/dashboard');
            case 'parent':
                return redirect('/parent/dashboard');
            default:
                return redirect('/login');
        }
    }
}