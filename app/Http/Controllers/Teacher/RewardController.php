<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\StudentReward;
use App\Models\StudentPoint;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index(Request $request)
    {
        $query = Reward::query();
        
        if ($request->has('classroom')) {
            $query->where('classroom_id', $request->classroom);
        } else {
            if (auth()->user()->role === 'teacher') {
                $classroomIds = auth()->user()->classrooms()->pluck('_id')->toArray();
                $query->whereIn('classroom_id', $classroomIds);
            } elseif (auth()->user()->role === 'student') {
                $classroomIds = auth()->user()->classroom_ids ?? [];
                $query->whereIn('classroom_id', $classroomIds)->where('is_active', true);
                
                $student = auth()->user();
                $query->where(function($q) use ($student) {
                    $q->where('level_requirement', '<=', $student->level ?? 1)
                      ->where(function($subQ) use ($student) {
                          $subQ->whereNull('character_specific')
                               ->orWhere('character_specific', [])
                               ->orWhereIn('character_specific', [$student->character_type]);
                      });
                });
            }
        }
        
        $rewards = $query->orderBy('rarity', 'desc')->orderBy('cost_points', 'asc')->get();
        
        if (auth()->user()->role === 'student') {
            $student = auth()->user();
            $rewards->each(function($reward) use ($student) {
                $reward->can_redeem = $reward->canBeRedeemedBy($student);
                $reward->times_purchased = $reward->studentRewards()
                                                  ->where('student_id', $student->id)
                                                  ->whereIn('status', ['approved', 'delivered'])
                                                  ->count();
            });
        }
        
        return view('teacher.rewards.index', compact('rewards'));
    }

    public function create(Request $request)
    {
        if (!$request->has('classroom') && auth()->user()->classrooms()->count() === 0) {
            return redirect()->route('classrooms.create')
                           ->with('error', 'Debes crear un aula antes de agregar recompensas.');
        }
        
        $characterTypes = [
            'mago' => 'Mago Sabio 🧙‍♂️',
            'guerrero' => 'Guerrero Valiente ⚔️',
            'ninja' => 'Ninja Ágil 🥷',
            'arquero' => 'Arquero Preciso 🏹',
            'lanzador' => 'Lanzador Creativo 🪄'
        ];
        
        return view('teacher.rewards.create', compact('characterTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'cost_points' => 'required|integer|min:1|max:10000',
            'type' => 'required|string|in:xp_boost,stat_boost,level_boost,character_upgrade,special_ability',
            'reward_type' => 'required|string|in:experience,stat,ability,cosmetic',
            'xp_bonus' => 'required|integer|min:0|max:1000',
            'rarity' => 'required|string|in:common,rare,epic,legendary',
            'level_requirement' => 'nullable|integer|min:1|max:100',
            'character_specific' => 'nullable|array',
            'character_specific.*' => 'string|in:mago,guerrero,ninja,arquero,lanzador',
            'duration_hours' => 'nullable|integer|min:1|max:8760',
            'max_uses_per_student' => 'nullable|integer|min:1|max:100',
            'stock_quantity' => 'nullable|integer|min:0',
            'effect_description' => 'nullable|string|max:500',
            'classroom_id' => 'required|string|exists:classrooms,_id'
        ]);

        $classroom = Classroom::findOrFail($request->classroom_id);
        if ($classroom->teacher_id !== auth()->id()) {
            abort(403, 'No tienes permisos para agregar recompensas a esta aula.');
        }

        $reward = Reward::create([
            'name' => $request->name,
            'description' => $request->description,
            'cost_points' => $request->cost_points,
            'type' => $request->type,
            'reward_type' => $request->reward_type,
            'xp_bonus' => $request->xp_bonus,
            'rarity' => $request->rarity,
            'level_requirement' => $request->level_requirement ?? 1,
            'character_specific' => $request->character_specific,
            'duration_hours' => $request->duration_hours,
            'max_uses_per_student' => $request->max_uses_per_student,
            'stock_quantity' => $request->stock_quantity,
            'effect_description' => $request->effect_description,
            'classroom_id' => $request->classroom_id,
            'icon' => $this->getIconForType($request->type, $request->rarity),
            'is_active' => true,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('teacher.rewards.index', ['classroom' => $request->classroom_id])
                        ->with('success', '¡Recompensa épica creada exitosamente! ⚡');
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'reward_id' => 'required|string|exists:rewards,_id',
            'classroom_id' => 'required|string|exists:classrooms,_id'
        ]);

        $reward = Reward::findOrFail($request->reward_id);
        $student = auth()->user();

        // Verificar que el estudiante pertenece al aula
        if (!in_array($request->classroom_id, $student->classroom_ids ?? [])) {
            return response()->json([
                'success' => false, 
                'message' => 'No perteneces a esta aula.'
            ], 403);
        }

        // Verificar si puede canjear la recompensa
        if (!$reward->canBeRedeemedBy($student)) {
            $reason = $this->getRedemptionErrorReason($reward, $student);
            return response()->json([
                'success' => false, 
                'message' => $reason
            ], 400);
        }

        // Verificar puntos del estudiante
        $studentPoint = StudentPoint::where('student_id', $student->id)
                                  ->where('classroom_id', $request->classroom_id)
                                  ->first();

        if (!$studentPoint || $studentPoint->total_points < $reward->cost_points) {
            return response()->json([
                'success' => false, 
                'message' => 'No tienes suficientes puntos para esta recompensa.'
            ], 400);
        }

        // Crear la recompensa del estudiante
        $expiresAt = null;
        if ($reward->duration_hours) {
            $expiresAt = now()->addHours($reward->duration_hours);
        }

        $studentReward = StudentReward::create([
            'student_id' => $student->id,
            'reward_id' => $reward->id,
            'classroom_id' => $request->classroom_id,
            'points_spent' => $reward->cost_points,
            'status' => 'pending',
            'redeemed_at' => now(),
            'expires_at' => $expiresAt,
            'is_permanent' => !$reward->duration_hours
        ]);

        // Descontar puntos
        $studentPoint->update([
            'total_points' => $studentPoint->total_points - $reward->cost_points,
            'points_spent' => ($studentPoint->points_spent ?? 0) + $reward->cost_points
        ]);

        // Reducir stock si aplica
        if ($reward->stock_quantity !== null) {
            $reward->decrement('stock_quantity');
        }

        return response()->json([
            'success' => true,
            'message' => '¡Recompensa canjeada! Espera la aprobación del maestro.',
            'data' => [
                'reward_name' => $reward->name,
                'xp_bonus' => $reward->xp_bonus,
                'remaining_points' => $studentPoint->total_points - $reward->cost_points
            ]
        ]);
    }

    public function updateRewardStatus(Request $request, StudentReward $studentReward)
    {
        $request->validate([
            'status' => 'required|string|in:pending,approved,delivered,cancelled'
        ]);

        $classroom = Classroom::findOrFail($studentReward->classroom_id);
        if ($classroom->teacher_id !== auth()->id()) {
            return response()->json([
                'success' => false, 
                'message' => 'No tienes permisos para esta acción.'
            ], 403);
        }

        $oldStatus = $studentReward->status;

        if ($request->status === 'approved' && $oldStatus === 'pending') {
            $student = User::find($studentReward->student_id);
            $reward = Reward::find($studentReward->reward_id);
            
            if ($student && $reward) {
                $effects = $reward->applyToStudent($student);
                $studentReward->update(['effects_applied' => $effects]);
                $student->increment('rewards_earned');
            }
        }

        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            $studentPoint = StudentPoint::where('student_id', $studentReward->student_id)
                                      ->where('classroom_id', $studentReward->classroom_id)
                                      ->first();
            
            if ($studentPoint) {
                $studentPoint->update([
                    'total_points' => $studentPoint->total_points + $studentReward->points_spent,
                    'points_spent' => max(0, ($studentPoint->points_spent ?? 0) - $studentReward->points_spent)
                ]);
            }

            $reward = Reward::find($studentReward->reward_id);
            if ($reward && $reward->stock_quantity !== null) {
                $reward->increment('stock_quantity');
            }
        }

        $studentReward->update([
            'status' => $request->status,
            'approved_by' => auth()->id(),
            'approved_at' => $request->status === 'approved' ? now() : null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado exitosamente.'
        ]);
    }

    public function show(Reward $reward)
    {
        $this->authorize('view', $reward);
        return view('teacher.rewards.show', compact('reward'));
    }

    public function edit(Reward $reward)
    {
        // Verificar permisos
        $classroom = Classroom::findOrFail($reward->classroom_id);
        if ($classroom->teacher_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'No tienes permisos para editar esta recompensa.');
        }
        
        $characterTypes = [
            'mago' => 'Mago Sabio 🧙‍♂️',
            'guerrero' => 'Guerrero Valiente ⚔️',
            'ninja' => 'Ninja Ágil 🥷',
            'arquero' => 'Arquero Preciso 🏹',
            'lanzador' => 'Lanzador Creativo 🪄'
        ];
        
        return view('teacher.rewards.edit', compact('reward', 'characterTypes'));
    }

    public function update(Request $request, Reward $reward)
    {
        $this->authorize('update', $reward);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'cost_points' => 'required|integer|min:1|max:10000',
            'type' => 'required|string|in:xp_boost,stat_boost,level_boost,character_upgrade,special_ability',
            'reward_type' => 'required|string|in:experience,stat,ability,cosmetic',
            'xp_bonus' => 'required|integer|min:0|max:1000',
            'rarity' => 'required|string|in:common,rare,epic,legendary',
            'level_requirement' => 'nullable|integer|min:1|max:100',
            'character_specific' => 'nullable|array',
            'duration_hours' => 'nullable|integer|min:1|max:8760',
            'max_uses_per_student' => 'nullable|integer|min:1|max:100',
            'stock_quantity' => 'nullable|integer|min:0',
            'effect_description' => 'nullable|string|max:500',
            'is_active' => 'boolean'
        ]);

        $reward->update([
            'name' => $request->name,
            'description' => $request->description,
            'cost_points' => $request->cost_points,
            'type' => $request->type,
            'reward_type' => $request->reward_type,
            'xp_bonus' => $request->xp_bonus,
            'rarity' => $request->rarity,
            'level_requirement' => $request->level_requirement,
            'character_specific' => $request->character_specific,
            'duration_hours' => $request->duration_hours,
            'max_uses_per_student' => $request->max_uses_per_student,
            'stock_quantity' => $request->stock_quantity,
            'effect_description' => $request->effect_description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('teacher.rewards.show', $reward)
                        ->with('success', 'Recompensa actualizada exitosamente.');
    }

    public function destroy(Reward $reward)
    {
        $this->authorize('delete', $reward);
        
        $redemptionCount = $reward->studentRewards()->count();
        
        if ($redemptionCount > 0) {
            return back()->with('error', 'No se puede eliminar una recompensa canjeada.');
        }

        $classroomId = $reward->classroom_id;
        $reward->delete();

        return redirect()->route('teacher.rewards.index', ['classroom' => $classroomId])
                        ->with('success', 'Recompensa eliminada exitosamente.');
    }

    public function toggleStatus(Reward $reward)
    {
        // Verificar permisos
        $classroom = Classroom::findOrFail($reward->classroom_id);
        if ($classroom->teacher_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false, 
                'message' => 'No tienes permisos para esta acción.'
            ], 403);
        }
        
        // Cambiar el estado
        $reward->update(['is_active' => !$reward->is_active]);
        
        return response()->json([
            'success' => true,
            'message' => $reward->is_active ? 'Recompensa activada exitosamente.' : 'Recompensa pausada exitosamente.',
            'is_active' => $reward->is_active
        ]);
    }

    // NUEVO MÉTODO: Aprobar todas las solicitudes pendientes
    public function approveAllPending(Reward $reward)
    {
        // Verificar permisos
        $classroom = Classroom::findOrFail($reward->classroom_id);
        if ($classroom->teacher_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false, 
                'message' => 'No tienes permisos para esta acción.'
            ], 403);
        }

        // Obtener todas las solicitudes pendientes
        $pendingRewards = $reward->studentRewards()->where('status', 'pending')->get();
        
        if ($pendingRewards->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No hay solicitudes pendientes para esta recompensa.'
            ]);
        }

        $approvedCount = 0;
        
        foreach ($pendingRewards as $studentReward) {
            try {
                // Aplicar efectos al estudiante
                $student = User::find($studentReward->student_id);
                if ($student && $reward) {
                    $effects = $reward->applyToStudent($student);
                    $student->increment('rewards_earned');
                    
                    // Actualizar estado de la recompensa del estudiante
                    $studentReward->update([
                        'status' => 'approved',
                        'approved_by' => auth()->id(),
                        'approved_at' => now(),
                        'effects_applied' => $effects
                    ]);
                    
                    $approvedCount++;
                }
            } catch (\Exception $e) {
                \Log::error("Error aprobando recompensa {$studentReward->id}: " . $e->getMessage());
                continue;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Se aprobaron {$approvedCount} solicitudes exitosamente.",
            'approved_count' => $approvedCount
        ]);
    }

    public function myRewards()
    {
        $student = auth()->user();
        
        $rewards = StudentReward::where('student_id', $student->id)
                               ->with(['reward', 'classroom'])
                               ->orderBy('created_at', 'desc')
                               ->get();

        $activeRewards = $rewards->filter(function($reward) {
            return $reward->isActive() && $reward->status === 'approved';
        });

        return view('students.rewards', compact('rewards', 'activeRewards'));
    }

    private function getIconForType($type, $rarity = 'common')
    {
        $baseIcons = [
            'xp_boost' => '⚡',
            'stat_boost' => '💪',
            'level_boost' => '🚀',
            'character_upgrade' => '✨',
            'special_ability' => '🔮'
        ];

        $rarityModifiers = [
            'common' => '',
            'rare' => '💎',
            'epic' => '👑',
            'legendary' => '🌟'
        ];

        $baseIcon = $baseIcons[$type] ?? '🎁';
        $modifier = $rarityModifiers[$rarity] ?? '';

        return $modifier . $baseIcon;
    }

    private function getRedemptionErrorReason(Reward $reward, User $student)
    {
        if ($reward->level_requirement && $student->level < $reward->level_requirement) {
            return "Necesitas ser nivel {$reward->level_requirement} para esta recompensa.";
        }

        if ($reward->character_specific && !in_array($student->character_type, $reward->character_specific)) {
            return "Esta recompensa es exclusiva para otros tipos de personaje.";
        }

        if ($reward->max_uses_per_student) {
            $usedCount = $reward->studentRewards()
                               ->where('student_id', $student->id)
                               ->whereIn('status', ['approved', 'delivered'])
                               ->count();
            
            if ($usedCount >= $reward->max_uses_per_student) {
                return "Ya alcanzaste el límite máximo de esta recompensa.";
            }
        }

        if (!$reward->is_active) {
            return "Esta recompensa no está disponible.";
        }

        if ($reward->stock_quantity !== null && $reward->stock_quantity <= 0) {
            return "Esta recompensa está agotada.";
        }

        return "No puedes canjear esta recompensa.";
    }

    protected function authorize($action, $reward)
    {
        $classroom = Classroom::findOrFail($reward->classroom_id);
        
        if ($classroom->teacher_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }
        
        return true;
    }
}