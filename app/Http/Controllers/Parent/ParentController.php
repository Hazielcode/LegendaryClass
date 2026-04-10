<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classroom;
use App\Models\StudentBehavior;
use App\Models\StudentReward;
use App\Models\StudentPoint;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:parent']);
        $this->middleware('check.parent.permission')->only(['childProgress', 'updateChild']);
    }

    public function dashboard()
    {
        $parent = auth()->user();
        $children = User::whereIn('_id', $parent->children_ids ?? [])->get();

        // Estadísticas de todos los hijos
        $stats = [
            'total_children' => $children->count(),
            'total_points' => $children->sum(function($child) {
                return $child->studentPoints->sum('total_points');
            }),
            'total_behaviors' => StudentBehavior::whereIn('student_id', $parent->children_ids ?? [])->count(),
            'pending_rewards' => StudentReward::whereIn('student_id', $parent->children_ids ?? [])
                                             ->where('status', 'pending')
                                             ->count(),
        ];

        // Actividad reciente de todos los hijos
        $recent_activities = StudentBehavior::whereIn('student_id', $parent->children_ids ?? [])
                                          ->with(['student', 'behavior', 'classroom'])
                                          ->latest()
                                          ->take(10)
                                          ->get();

        return view('parent.dashboard', compact('children', 'stats', 'recent_activities'));
    }

    public function childProgress($childId)
    {
        $parent = auth()->user();
        
        // Verificar que el niño pertenece al padre
        if (!in_array($childId, $parent->children_ids ?? [])) {
            abort(403, 'No tienes acceso a este estudiante');
        }

        $child = User::findOrFail($childId);
        $classrooms = $child->getAccessibleClassrooms();
        
        // Progreso del niño por aula
        $progress_by_classroom = $classrooms->map(function($classroom) use ($child) {
            $studentPoint = StudentPoint::where('student_id', $child->id)
                                      ->where('classroom_id', $classroom->id)
                                      ->first();
            
            return [
                'classroom' => $classroom,
                'points' => $studentPoint->total_points ?? 0,
                'level' => $studentPoint->level ?? 1,
                'achievements' => $studentPoint->achievements ?? [],
            ];
        });

        // Comportamientos recientes del niño
        $recent_behaviors = StudentBehavior::where('student_id', $child->id)
                                         ->with(['behavior', 'classroom'])
                                         ->latest()
                                         ->take(20)
                                         ->get();

        // Recompensas del niño
        $rewards = StudentReward::where('student_id', $child->id)
                               ->with(['reward'])
                               ->latest()
                               ->take(10)
                               ->get();

        return view('parent.child-progress', compact('child', 'progress_by_classroom', 'recent_behaviors', 'rewards'));
    }

    public function classroomView($classroomId)
    {
        $parent = auth()->user();
        $classroom = Classroom::findOrFail($classroomId);
        
        // Verificar que al menos uno de sus hijos está en esta aula
        $childrenInClassroom = User::whereIn('_id', $parent->children_ids ?? [])
                                 ->whereIn('_id', $classroom->student_ids ?? [])
                                 ->get();
        
        if ($childrenInClassroom->isEmpty()) {
            abort(403, 'No tienes hijos en esta aula');
        }

        // Información del aula
        $teacher = $classroom->teacher;
        $behaviors = $classroom->behaviors()->where('is_active', true)->get();
        $rewards = $classroom->rewards()->where('is_active', true)->get();

        // Progreso de sus hijos en esta aula
        $children_progress = $childrenInClassroom->map(function($child) use ($classroom) {
            $studentPoint = StudentPoint::where('student_id', $child->id)
                                      ->where('classroom_id', $classroom->id)
                                      ->first();
            
            $recentBehaviors = StudentBehavior::where('student_id', $child->id)
                                            ->where('classroom_id', $classroom->id)
                                            ->with('behavior')
                                            ->latest()
                                            ->take(5)
                                            ->get();
            
            return [
                'child' => $child,
                'points' => $studentPoint->total_points ?? 0,
                'level' => $studentPoint->level ?? 1,
                'recent_behaviors' => $recentBehaviors,
            ];
        });

        return view('parent.classroom-view', compact('classroom', 'teacher', 'behaviors', 'rewards', 'children_progress'));
    }

    public function linkChild(Request $request)
    {
        $request->validate([
            'child_email' => 'required|email|exists:users,email'
        ]);

        $child = User::where('email', $request->child_email)
                    ->where('role', 'student')
                    ->first();

        if (!$child) {
            return back()->withErrors(['child_email' => 'No se encontró un estudiante con ese email']);
        }

        $parent = auth()->user();
        $childrenIds = $parent->children_ids ?? [];

        if (in_array($child->id, $childrenIds)) {
            return back()->withErrors(['child_email' => 'Este estudiante ya está vinculado a tu cuenta']);
        }

        // Agregar hijo al padre
        $childrenIds[] = $child->id;
        $parent->update(['children_ids' => $childrenIds]);

        // Actualizar email del padre en el hijo
        $child->update(['parent_email' => $parent->email]);

        return back()->with('success', 'Estudiante vinculado exitosamente');
    }

    public function unlinkChild($childId)
    {
        $parent = auth()->user();
        
        // Verificar que es su hijo
        if (!in_array($childId, $parent->children_ids ?? [])) {
            abort(403, 'No puedes desvincular este estudiante');
        }

        $childrenIds = array_filter($parent->children_ids ?? [], function($id) use ($childId) {
            return $id !== $childId;
        });

        $parent->update(['children_ids' => array_values($childrenIds)]);

        // Limpiar email del padre en el hijo
        $child = User::find($childId);
        if ($child) {
            $child->update(['parent_email' => null]);
        }

        return back()->with('success', 'Vinculación eliminada exitosamente');
    }

    /**
     * Actualizar información básica del hijo (solo campos permitidos)
     */
    public function updateChild(Request $request, $childId)
    {
        $parent = auth()->user();
        
        // Verificar que es su hijo
        if (!in_array($childId, $parent->children_ids ?? [])) {
            abort(403, 'No puedes editar este estudiante');
        }

        $child = User::findOrFail($childId);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
        ]);

        $child->update($request->only(['name', 'phone', 'date_of_birth']));

        return back()->with('success', 'Información del estudiante actualizada exitosamente');
    }
}