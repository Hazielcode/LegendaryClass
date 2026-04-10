<?php
// app/Http/Controllers/DirectorController.php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classroom;
use App\Models\StudentBehavior;
use App\Models\StudentReward;
use App\Models\StudentPoint;
use App\Models\Behavior;
use App\Models\Reward;
use Illuminate\Http\Request;

class DirectorController extends Controller
{
    // Constructor sin middleware - se maneja en rutas
    public function __construct()
    {
        // Middleware manejado en web.php
    }

    // Dashboard principal del director con datos corregidos
    public function dashboard()
    {
        try {
            \Log::info('DirectorController dashboard ejecutándose para usuario: ' . auth()->user()->name);
            
            // Estadísticas principales con consultas directas
            $stats = [
                'total_teachers' => User::where('role', 'teacher')->count(),
                'total_students' => User::where('role', 'student')->count(),
                'total_parents' => User::where('role', 'parent')->count(),
                'total_classrooms' => Classroom::count(),
                'active_classrooms' => Classroom::where('is_active', true)->count(),
                'total_behaviors_awarded' => StudentBehavior::count(),
                'total_rewards_redeemed' => StudentReward::whereIn('status', ['approved', 'delivered'])->count(),
                'total_points_awarded' => StudentPoint::sum('total_points') ?? 0,
            ];

            // Estadísticas mensuales
            $monthly_stats = [
                'behaviors_this_month' => StudentBehavior::whereMonth('created_at', now())->count(),
                'rewards_this_month' => StudentReward::whereMonth('created_at', now())->count(),
                'new_students_this_month' => User::where('role', 'student')->whereMonth('created_at', now())->count(),
                'points_awarded_this_month' => StudentPoint::whereMonth('created_at', now())->sum('total_points') ?? 0,
            ];

            // Información de debug solo en desarrollo
            $debug_info = config('app.debug') ? [
                'controller_active' => 'FUNCIONANDO',
                'user_role' => auth()->user()->role,
                'user_name' => auth()->user()->name,
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'view_path' => 'director.dashboard',
                'stats_loaded' => 'SI',
                'db_connection' => 'OK'
            ] : null;

            // Actividades recientes limitadas
            $recent_activities = StudentBehavior::with(['student', 'behavior', 'classroom'])
                                              ->orderBy('created_at', 'desc')
                                              ->limit(10)
                                              ->get();

            // Aulas activas con información completa
            $active_classrooms = Classroom::where('is_active', true)
                                        ->with(['teacher'])
                                        ->limit(5)
                                        ->get();

            return view('director.dashboard', compact(
                'stats', 
                'debug_info', 
                'recent_activities', 
                'active_classrooms', 
                'monthly_stats'
            ));

        } catch (\Exception $e) {
            \Log::error('Error en DirectorController dashboard: ' . $e->getMessage());
            
            // Valores por defecto en caso de error
            $stats = [
                'total_teachers' => 0,
                'total_students' => 0,
                'total_parents' => 0,
                'total_classrooms' => 0,
                'active_classrooms' => 0,
                'total_behaviors_awarded' => 0,
                'total_rewards_redeemed' => 0,
                'total_points_awarded' => 0,
            ];

            $monthly_stats = [
                'behaviors_this_month' => 0,
                'rewards_this_month' => 0,
                'new_students_this_month' => 0,
                'points_awarded_this_month' => 0,
            ];

            $debug_info = [
                'error' => $e->getMessage(),
                'controller' => 'DirectorController',
                'method' => 'dashboard'
            ];

            $recent_activities = collect();
            $active_classrooms = collect();

            return view('director.dashboard', compact('stats', 'debug_info', 'monthly_stats', 'recent_activities', 'active_classrooms'))
                   ->with('error', 'Error al cargar el dashboard: ' . $e->getMessage());
        }
    }

    // Vista de gestión de maestros
    public function teachers()
    {
        try {
            $teachers = User::where('role', 'teacher')->get()->map(function ($teacher) {
                $teacher->classrooms_count = Classroom::where('teacher_id', $teacher->_id)->count();
                $teacher->awardedBehaviors_count = StudentBehavior::where('awarded_by', $teacher->_id)->count();
                return $teacher;
            });

            return view('director.teachers', compact('teachers'));
        } catch (\Exception $e) {
            return view('director.teachers', ['teachers' => collect()])
                   ->with('error', 'Error al cargar maestros: ' . $e->getMessage());
        }
    }

    // Vista de gestión de estudiantes
    public function students()
    {
        try {
            $students = User::where('role', 'student')->get()->map(function ($student) {
                $studentPoint = StudentPoint::where('student_id', $student->_id)->first();
                $student->total_points = $studentPoint->total_points ?? 0;
                $student->current_level = $studentPoint->level ?? 1;
                return $student;
            });

            return view('director.students', compact('students'));
        } catch (\Exception $e) {
            return view('director.students', ['students' => collect()])
                   ->with('error', 'Error al cargar estudiantes: ' . $e->getMessage());
        }
    }

    // Vista de gestión de aulas
    public function classrooms()
    {
        try {
            $classrooms = Classroom::with('teacher')->get()->map(function ($classroom) {
                $classroom->behaviors_count = StudentBehavior::where('classroom_id', $classroom->_id)->count();
                $classroom->rewards_count = StudentReward::where('classroom_id', $classroom->_id)->count();
                $classroom->students_count = count($classroom->student_ids ?? []);
                return $classroom;
            });

            return view('director.classrooms', compact('classrooms'));
        } catch (\Exception $e) {
            return view('director.classrooms', ['classrooms' => collect()])
                   ->with('error', 'Error al cargar aulas: ' . $e->getMessage());
        }
    }

    // Vista de reportes
public function reports()
{
    try {
        $monthly_stats = [
            'behaviors_this_month' => StudentBehavior::whereMonth('created_at', now())->count(),
            'rewards_this_month' => StudentReward::whereMonth('created_at', now())->count(),
            'new_students_this_month' => User::where('role', 'student')->whereMonth('created_at', now())->count(),
            'points_awarded_this_month' => StudentPoint::whereMonth('created_at', now())->sum('total_points') ?? 0,
        ];

        // Arreglar consulta de top students para MongoDB
        $top_students = User::where('role', 'student')->get()->map(function ($student) {
            $studentPoint = StudentPoint::where('student_id', $student->_id)->first();
            $student->total_points = $studentPoint->total_points ?? 0;
            return $student;
        })->sortByDesc('total_points')->take(10);

        // Arreglar consulta de behavior trends para MongoDB
        $behavior_trends = Behavior::all()->map(function ($behavior) {
            $behavior->student_behaviors_count = StudentBehavior::where('behavior_id', $behavior->_id)->count();
            return $behavior;
        });

        return view('director.reports', compact('monthly_stats', 'top_students', 'behavior_trends'));
    } catch (\Exception $e) {
        return back()->with('error', 'Error al cargar reportes: ' . $e->getMessage());
    }
}


    // Vista de gestión de usuarios
    public function userManagement()
    {
        try {
            $users = User::where('role', '!=', 'director')->get();
            $stats = [
                'total_users' => User::count(),
                'active_users' => User::where('is_active', true)->count(),
                'inactive_users' => User::where('is_active', false)->count(),
            ];

            return view('director.user-management', compact('users', 'stats'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar gestión de usuarios: ' . $e->getMessage());
        }
    }

    // Actualizar rol de usuario
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:teacher,student,parent,admin'
        ]);

        try {
            $user->role = $request->role;
            $user->save();

            return back()->with('success', '👑 Rol actualizado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar rol: ' . $e->getMessage());
        }
    }

    // Activar/desactivar usuario
    public function toggleUserStatus(User $user)
    {
        try {
            $user->is_active = !$user->is_active;
            $user->save();

            $status = $user->is_active ? 'activado' : 'desactivado';
            return back()->with('success', "👑 Usuario {$status} exitosamente");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cambiar estado: ' . $e->getMessage());
        }
    }

    // Crear nuevo usuario desde el panel imperial
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:teacher,student,parent,admin',
            'password' => 'required|string|min:8',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt($request->password),
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            return back()->with('success', '👑 Nuevo súbdito agregado al reino exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear usuario: ' . $e->getMessage());
        }
    }

    // API para estadísticas en tiempo real
    public function getStats()
    {
        try {
            $stats = [
                'total_users' => User::count(),
                'active_classrooms' => Classroom::where('is_active', true)->count(),
                'behaviors_today' => StudentBehavior::whereDate('created_at', today())->count(),
                'points_today' => StudentPoint::whereDate('created_at', today())->sum('total_points') ?? 0,
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener estadísticas'], 500);
        }
    }
}