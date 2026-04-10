<?php

namespace App\Http\Controllers\Teacher;


use App\Http\Controllers\Controller;
use App\Models\Behavior;
use App\Models\Classroom;
use Illuminate\Http\Request;

class BehaviorController extends Controller
{
    public function index(Request $request)
    {
        $query = Behavior::query();
        
        if ($request->has('classroom')) {
            $query->where('classroom_id', $request->classroom);
        } else {
            // Solo mostrar comportamientos de las aulas del profesor
            $classroomIds = auth()->user()->classrooms()->pluck('_id')->toArray();
            $query->whereIn('classroom_id', $classroomIds);
        }
        
        $behaviors = $query->orderBy('type', 'asc')
                          ->orderBy('category', 'asc')
                          ->get();
        
        return view('teacher.behaviors.index', compact('behaviors'));
    }

    public function create(Request $request)
    {
        // Verificar que el usuario tenga al menos un aula
        if (!$request->has('classroom') && auth()->user()->classrooms()->count() === 0) {
            return redirect()->route('teacher.classrooms.create')
                           ->with('error', 'Debes crear un aula antes de agregar comportamientos.');
        }
        
        return view('teacher.behaviors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:positive,negative',
            'points' => 'required|integer|min:-100|max:100',
            'category' => 'required|string|in:participation,homework,behavior,creativity,teamwork,punctuality,respect,effort',
            'color' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
            'classroom_id' => 'required|string|exists:classrooms,_id'
        ]);

        // Verificar que el usuario sea el profesor del aula
        $classroom = Classroom::findOrFail($request->classroom_id);
        if ($classroom->teacher_id !== auth()->id()) {
            abort(403, 'No tienes permisos para agregar comportamientos a esta aula.');
        }

        $behavior = Behavior::create([
            'name' => $request->name,
            'description' => $request->description ?? $request->name,
            'type' => $request->type,
            'points' => $request->points,
            'category' => $request->category,
            'color' => $request->color ?? ($request->type === 'positive' ? '#10B981' : '#EF4444'),
            'classroom_id' => $request->classroom_id,
            'icon' => $this->getIconForCategory($request->category),
            'is_active' => true,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('teacher.behaviors.index', ['classroom' => $request->classroom_id])
                        ->with('success', 'Comportamiento creado exitosamente.');
    }

    public function show(Behavior $behavior)
    {
        $this->authorize('view', $behavior);
        return view('teacher.behaviors.show', compact('behavior'));
    }

    public function edit(Behavior $behavior)
    {
        $this->authorize('update', $behavior);
        return view('teacher.behaviors.edit', compact('behavior'));
    }

    public function update(Request $request, Behavior $behavior)
    {
        $this->authorize('update', $behavior);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:positive,negative',
            'points' => 'required|integer|min:-100|max:100',
            'category' => 'required|string|in:participation,homework,behavior,creativity,teamwork,punctuality,respect,effort',
            'color' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
            'is_active' => 'boolean'
        ]);

        $behavior->update([
            'name' => $request->name,
            'description' => $request->description ?? $request->name,
            'type' => $request->type,
            'points' => $request->points,
            'category' => $request->category,
            'color' => $request->color ?? $behavior->color,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('teacher.behaviors.index', ['classroom' => $behavior->classroom_id])
                        ->with('success', 'Comportamiento actualizado exitosamente.');
    }

    public function destroy(Behavior $behavior)
    {
        $this->authorize('delete', $behavior);
        
        // Verificar si el comportamiento ha sido usado
        $usageCount = $behavior->studentBehaviors()->count();
        
        if ($usageCount > 0) {
            return back()->with('error', 'No se puede eliminar un comportamiento que ya ha sido utilizado. Puedes desactivarlo en su lugar.');
        }

        $classroomId = $behavior->classroom_id;
        $behavior->delete();

        return redirect()->route('teacher.behaviors.index', ['classroom' => $classroomId])
                        ->with('success', 'Comportamiento eliminado exitosamente.');
    }

    private function getIconForCategory($category)
    {
        $icons = [
            'participation' => '🙋',
            'homework' => '📝',
            'behavior' => '😊',
            'creativity' => '🎨',
            'teamwork' => '🤝',
            'punctuality' => '⏰',
            'respect' => '🤲',
            'effort' => '💪'
        ];

        return $icons[$category] ?? '⭐';
    }
}