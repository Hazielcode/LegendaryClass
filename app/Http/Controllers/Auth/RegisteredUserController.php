<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['sometimes', 'string', 'in:student,teacher,parent,director,admin'],
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->role = $request->role ?? 'student';
    $user->is_active = true;

    // Valores iniciales para el sistema de gamificación
    $user->experience_points = 0;
    $user->level = 1;
    $user->points = 100;
    $user->achievements_count = 0;
    $user->quests_completed = 0;
    $user->positive_points = 0;
    $user->negative_points = 0;
    $user->rewards_earned = 0;
    $user->login_streak = 0;
    $user->homework_completed = 0;
    $user->books_read = 0;
    $user->peers_helped = 0;
    $user->creative_projects = 0;
    $user->students_mentored = 0;
    $user->weekly_positive = 0;
    $user->weekly_tasks = 0;
    $user->weekly_xp = 0;
    $user->first_character_selection = false;

    // Estadísticas del personaje con valores iniciales
    $user->strength = 10;
    $user->intelligence = 10;
    $user->agility = 10;
    $user->creativity = 10;
    $user->leadership = 10;
    $user->resilience = 10;

    $user->save();

    event(new Registered($user));

    Auth::login($user);

    if ($user->role === 'student') {
        return redirect()->route('students.character.select');
    }
    
    return redirect(route('dashboard', absolute: false));
}
}