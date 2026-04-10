<?php
// Archivo: app/Http/Middleware/CheckParentPermission.php (CREAR NUEVO)

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckParentPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        // Si es admin o director, tiene acceso completo
        if ($user->hasAdminAccess()) {
            return $next($request);
        }

        // Si es padre, verificar permisos específicos
        if ($user->role === 'parent') {
            // Obtener el ID del usuario que intenta editar/ver
            $targetUserId = $request->route('user') ?? 
                           $request->route('id') ?? 
                           $request->route('child') ??
                           $request->input('user_id') ??
                           $request->input('child_id');
            
            if ($targetUserId) {
                // Verificar si puede acceder a este usuario
                if (!$this->canAccessUser($user, $targetUserId)) {
                    abort(403, 'No tienes permisos para acceder a esta información.');
                }
            }
        }

        return $next($request);
    }

    /**
     * Verificar si un padre puede acceder a un usuario específico
     */
    private function canAccessUser($parent, $targetUserId)
    {
        // El padre puede acceder a su propia información
        if ($parent->id === $targetUserId) {
            return true;
        }

        // El padre puede acceder a la información de sus hijos
        return in_array($targetUserId, $parent->children_ids ?? []);
    }
}