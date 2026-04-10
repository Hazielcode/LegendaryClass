<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Verificar si el usuario está activo
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Tu cuenta está desactivada. Contacta al administrador.'
            ]);
        }

        $userRole = $user->role;

        // El director siempre tiene acceso (excepto si se especifica explícitamente que no)
        if ($userRole === 'director' && !in_array('!director', $roles)) {
            // Guardar información de la clase del director en sesión
            session(['adventurer_class' => [
                'class' => 'Director',
                'icon' => '👑',
                'color' => 'purple',
                'level' => $user->level ?? 'Supremo',
                'role' => $userRole
            ]]);
            return $next($request);
        }

        // Admin siempre tiene acceso (excepto si se especifica explícitamente que no)
        if ($userRole === 'admin' && !in_array('!admin', $roles)) {
            // Guardar información de la clase del admin en sesión
            session(['adventurer_class' => [
                'class' => 'Administrador',
                'icon' => '⚡',
                'color' => 'blue',
                'level' => $user->level ?? 'Máximo',
                'role' => $userRole
            ]]);
            return $next($request);
        }

        // Verificar si el usuario tiene el rol requerido
        if (!in_array($userRole, $roles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Guardar información de la clase del usuario en sesión según su rol
        $adventurerClasses = [
            'teacher' => [
                'class' => 'Maestro',
                'icon' => '🧙‍♂️',
                'color' => 'blue',
                'level' => $user->level ?? 'Sabio',
                'role' => $userRole
            ],
            'student' => [
                'class' => $user->character_class ?? 'Alumno',
                'icon' => $user->character_icon ?? '⚔️',
                'color' => 'green',
                'level' => $user->level ?? 1,
                'role' => $userRole
            ],
            'parent' => [
                'class' => 'Padre',
                'icon' => '🛡️',
                'color' => 'yellow',
                'level' => 'Guardián',
                'role' => $userRole
            ]
        ];

        if (isset($adventurerClasses[$userRole])) {
            session(['adventurer_class' => $adventurerClasses[$userRole]]);
        }

        return $next($request);
    }
}