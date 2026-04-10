<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequireCharacterSelection
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
{
    if (!Auth::check()) {
        return $next($request);
    }

    $user = Auth::user();
    
    // Solo aplicar a estudiantes
    if ($user->role !== 'student') {
        return $next($request);
    }
    
    // Si es un usuario recién creado (menos de 5 minutos), permitir acceso
    if ($user->created_at && $user->created_at->diffInMinutes(now()) < 5) {
        // Redirigir a selección si no ha seleccionado personaje
        if (!$user->first_character_selection && !$request->routeIs('students.character.select') && !$request->routeIs('students.character.store')) {
            return redirect()->route('students.character.select');
        }
        return $next($request);
    }

    // Para usuarios existentes, verificar selección de personaje
    if (!$user->first_character_selection) {
        if ($request->routeIs('students.character.select') || $request->routeIs('students.character.store')) {
            return $next($request);
        }
        return redirect()->route('students.character.select');
    }

    return $next($request);
}
}