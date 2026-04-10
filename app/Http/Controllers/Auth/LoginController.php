<?php
// Archivo: app/Http/Controllers/Auth/LoginController.php (ACTUALIZAR EL EXISTENTE)

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirigir usuarios después del login según su rol (DETECCIÓN AUTOMÁTICA)
     */
    protected function redirectTo()
    {
        $user = Auth::user();
        
        // Detectar automáticamente el tipo de usuario según su rol en la base de datos
        switch ($user->role) {
            case 'director':
                return '/director/dashboard';
            case 'teacher':
                return '/dashboard'; // O la ruta específica de profesores
            case 'student':
                return '/students/dashboard';
            case 'parent':
                return '/parent/dashboard';
            case 'admin':
                return '/dashboard';
            default:
                return '/dashboard';
        }
    }

    /**
     * Manejar el login después de la validación
     */
    protected function authenticated(Request $request, $user)
    {
        // Mostrar mensaje de bienvenida según el rol
        $roleMessages = [
            'director' => '👑 ¡Bienvenido, Gran Rey de la Academia!',
            'teacher' => '🧙‍♂️ ¡Bienvenido, Maestro Guía del Conocimiento!',
            'student' => '⚔️ ¡Bienvenido, Valiente Guerrero del Saber!',
            'parent' => '🛡️ ¡Bienvenido, Noble Guardián Protector!',
            'admin' => '👤 ¡Bienvenido, Administrador del Sistema!'
        ];

        $message = $roleMessages[$user->role] ?? '¡Bienvenido, Aventurero!';
        
        session()->flash('welcome_message', $message);
        
        return redirect($this->redirectTo());
    }

    /**
     * Validar credenciales y verificar que el usuario esté activo
     */
    protected function credentials(Request $request)
    {
        return array_merge(
            $request->only($this->username(), 'password'),
            ['is_active' => true]
        );
    }

    /**
     * Manejar intento de login fallido
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if ($user && !$user->is_active) {
            $errors = ['email' => 'Tu cuenta está desactivada. Contacta al administrador.'];
        } else {
            $errors = ['email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.'];
        }
        
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Mostrar formulario de login personalizado
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
}