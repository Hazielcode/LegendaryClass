<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Quest;
use App\Models\Achievement;
use App\Models\Reward;
use App\Models\ExperienceLog;

class StudentsController extends Controller
{
    /**
     * Dashboard del estudiante
     */
    /**
 * Dashboard del estudiante - VERSIÓN CORREGIDA
 */
public function dashboard()
{
    \Log::info('Dashboard method called for user: ' . Auth::user()->email);
    
    try {
        $user = Auth::user();
        
        if (!$user->first_character_selection) {
            return redirect()->route('students.character.select');
        }
        
        // Inicializar variables con colecciones vacías por defecto
        $myClassrooms = collect();
        $activeQuests = collect();
        $recentAchievements = collect();
        $availableRewards = collect();
        
        // Obtener aulas del estudiante
        try {
            if (class_exists(Classroom::class)) {
                $myClassrooms = Classroom::whereIn('student_ids', [$user->_id])
                    ->with('teacher')
                    ->get();
                
                \Log::info('Aulas encontradas para usuario ' . $user->email . ': ' . $myClassrooms->count());
            }
        } catch (\Exception $e) {
            \Log::warning('Error loading classrooms: ' . $e->getMessage());
            $myClassrooms = collect();
        }
        
        // Obtener misiones activas
        try {
            if (class_exists(Quest::class)) {
                $activeQuests = Quest::where('students', 'all', [$user->_id])
                    ->where('status', 'active')
                    ->get();
            }
        } catch (\Exception $e) {
            \Log::warning('Error loading quests: ' . $e->getMessage());
        }
        
        // Si no tiene misiones reales, mostrar datos de ejemplo
        if ($activeQuests->isEmpty()) {
            $activeQuests = collect([
                (object)[
                    'id' => 1,
                    'title' => 'Resolver ecuaciones cuadráticas',
                    'description' => 'Completa los ejercicios 1-15 del capítulo 7',
                    'xp_reward' => 75,
                    'type' => 'homework'
                ],
                (object)[
                    'id' => 2,
                    'title' => 'Experimento de química',
                    'description' => 'Realizar el experimento de mezclas y escribir reporte',
                    'xp_reward' => 100,
                    'type' => 'project'
                ],
                (object)[
                    'id' => 3,
                    'title' => 'Ensayo sobre la fotosíntesis',
                    'description' => 'Escribir un ensayo de 500 palabras sobre el proceso',
                    'xp_reward' => 60,
                    'type' => 'writing'
                ]
            ]);
        }
        
        // Obtener logros recientes
        try {
            if (class_exists(Achievement::class)) {
                $recentAchievements = Achievement::where('user_id', $user->_id)
                    ->orderBy('unlocked_at', 'desc')
                    ->limit(3)
                    ->get();
            }
        } catch (\Exception $e) {
            \Log::warning('Error loading achievements: ' . $e->getMessage());
        }
        
        // Si no tiene logros reales, mostrar datos de ejemplo
        if ($recentAchievements->isEmpty()) {
            $recentAchievements = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Primera Misión',
                    'description' => 'Completaste tu primera misión exitosamente',
                    'icon' => '🗡️',
                    'xp_reward' => 25,
                    'unlocked_at' => now()->subDays(3)
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Estudiante Dedicado',
                    'description' => 'Completaste 5 tareas consecutivas',
                    'icon' => '📚',
                    'xp_reward' => 50,
                    'unlocked_at' => now()->subDays(7)
                ]
            ]);
        }
        
        // Obtener recompensas disponibles - DATOS ÚNICOS Y VARIADOS
        try {
            if (class_exists(Reward::class)) {
                $availableRewards = Reward::where('is_active', true)
                    ->where('cost_points', '<=', ($user->points ?? 0) + 200)
                    ->orderBy('cost_points', 'asc')
                    ->limit(4)
                    ->get();
            }
        } catch (\Exception $e) {
            \Log::warning('Error loading rewards: ' . $e->getMessage());
        }
        
        // Si no hay recompensas reales, mostrar datos de ejemplo ÚNICOS
        if ($availableRewards->isEmpty()) {
            $availableRewards = collect([
                (object)[
                    'id' => 1,
                    '_id' => 1,
                    'name' => 'Poción de Sabiduría',
                    'description' => 'Aumenta tu experiencia en las próximas 3 tareas',
                    'icon' => '🧪',
                    'cost' => 50,
                    'cost_points' => 50,
                    'rarity' => 'common',
                    'type' => 'temporary',
                    'xp_bonus' => 25,
                    'level_requirement' => 1
                ],
                (object)[
                    'id' => 2,
                    '_id' => 2,
                    'name' => 'Tiempo Extra de Recreo',
                    'description' => '15 minutos adicionales de recreo por una semana',
                    'icon' => '🎮',
                    'cost' => 40,
                    'cost_points' => 40,
                    'rarity' => 'common',
                    'type' => 'privilege',
                    'level_requirement' => 1
                ],
                (object)[
                    'id' => 3,
                    '_id' => 3,
                    'name' => 'Certificado de Honor',
                    'description' => 'Un certificado personalizado que reconoce tu esfuerzo',
                    'icon' => '🏆',
                    'cost' => 120,
                    'cost_points' => 120,
                    'rarity' => 'rare',
                    'type' => 'physical',
                    'level_requirement' => 5
                ],
                (object)[
                    'id' => 4,
                    '_id' => 4,
                    'name' => 'Lápiz Legendario',
                    'description' => 'Un lápiz especial con tu nombre grabado',
                    'icon' => '✏️',
                    'cost' => 60,
                    'cost_points' => 60,
                    'rarity' => 'common',
                    'type' => 'physical',
                    'level_requirement' => 1
                ]
            ]);
        }
        
        return view('students.dashboard', compact(
            'myClassrooms',
            'activeQuests', 
            'recentAchievements',
            'availableRewards'
        ));
        
    } catch (\Exception $e) {
        \Log::error('Error in StudentsController@dashboard: ' . $e->getMessage());
        
        // En caso de error, mostrar dashboard con datos vacíos
        return view('students.dashboard', [
            'myClassrooms' => collect(),
            'activeQuests' => collect(),
            'recentAchievements' => collect(),
            'availableRewards' => collect()
        ]);
    }
}

    /**
     * Mostrar las aulas del estudiante
     */
    /**
 * Mostrar las aulas del estudiante
 */
/**
 * Mostrar las aulas del estudiante
 */
public function classrooms()
{
    try {
        $user = Auth::user();
        
        // Obtener aulas donde el estudiante está inscrito
        $myClassrooms = Classroom::whereIn('student_ids', [$user->_id])
            ->with('teacher')
            ->get();
        
        // Si la consulta normal falla, usar método alternativo
        if ($myClassrooms->isEmpty()) {
            // Buscar en todas las aulas manualmente
            $allClassrooms = Classroom::all();
            $myClassrooms = $allClassrooms->filter(function($classroom) use ($user) {
                return in_array($user->_id, $classroom->student_ids ?? []);
            });
        }
        
        return view('students.classrooms.index', compact('myClassrooms'));
        
    } catch (\Exception $e) {
        \Log::error('Error in StudentsController@classrooms: ' . $e->getMessage());
        
        return view('students.classrooms.index', [
            'myClassrooms' => collect()
        ]);
    }
}

    /**
     * Mostrar las misiones del estudiante
     */
    public function myQuests()
    {
        try {
            $user = Auth::user();
            $quests = collect();
            
            if (class_exists(Quest::class)) {
                $quests = Quest::where('students', 'all', [$user->_id])
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            
            // Si no hay misiones reales, mostrar datos de ejemplo
            if ($quests->isEmpty()) {
                $quests = collect([
                    (object)[
                        'id' => 1,
                        'title' => 'Resolver ecuaciones cuadráticas',
                        'description' => 'Completa los ejercicios 1-15 del capítulo 7',
                        'xp_reward' => 75,
                        'type' => 'homework',
                        'status' => 'active',
                        'due_date' => now()->addDays(3)
                    ],
                    (object)[
                        'id' => 2,
                        'title' => 'Experimento de química',
                        'description' => 'Realizar el experimento de mezclas y escribir reporte',
                        'xp_reward' => 100,
                        'type' => 'project',
                        'status' => 'active',
                        'due_date' => now()->addDays(7)
                    ],
                    (object)[
                        'id' => 3,
                        'title' => 'Ensayo sobre la fotosíntesis',
                        'description' => 'Escribir un ensayo de 500 palabras sobre el proceso',
                        'xp_reward' => 60,
                        'type' => 'writing',
                        'status' => 'completed',
                        'due_date' => now()->subDays(2)
                    ]
                ]);
            }
            
            return view('students.quests.index', compact('quests'));
            
        } catch (\Exception $e) {
            \Log::error('Error in myQuests: ' . $e->getMessage());
            return view('students.quests.index', ['quests' => collect()]);
        }
    }

    /**
     * Abandonar un aula
     */
    public function leaveClassroom(Request $request, $classroomId)
    {
        try {
            $user = Auth::user();
            
            if (class_exists(Classroom::class)) {
                $classroom = Classroom::findOrFail($classroomId);
                
                // Verificar que el estudiante esté en el aula
                $studentIds = $classroom->student_ids ?? [];
                
                if (!in_array($user->_id, $studentIds)) {
                    return redirect()->route('students.dashboard')
                        ->with('error', 'No estás inscrito en esta aula');
                }
                
                // Remover al estudiante del aula
                $newStudentIds = array_filter($studentIds, function($id) use ($user) {
                    return $id !== $user->_id;
                });
                
                $classroom->update(['student_ids' => array_values($newStudentIds)]);
                
                return redirect()->route('students.dashboard')
                    ->with('success', 'Has abandonado el aula exitosamente');
            }
            
            // Si no existe el modelo, simular éxito
            return redirect()->route('students.dashboard')
                ->with('success', 'Has abandonado el aula exitosamente');
                
        } catch (\Exception $e) {
            \Log::error('Error in leaveClassroom: ' . $e->getMessage());
            return redirect()->route('students.dashboard')
                ->with('error', 'Error al abandonar el aula');
        }
    }

    /**
     * Completar misión - CON SISTEMA DE EVOLUCIÓN
     */
    public function completeQuest(Request $request, $questId)
    {
        try {
            $user = Auth::user();
            $oldLevel = $user->level ?? 1;
            $oldTier = $this->getCharacterTier($oldLevel);
            
            // Simular completar misión con datos de ejemplo
            $xpGained = rand(50, 150);
            
            // Aplicar bonus del personaje si tiene uno
            if ($user->character_bonus_type) {
                $xpGained = (int) ($xpGained * 1.2);
            }

            $user->increment('experience_points', $xpGained);
            $user->increment('quests_completed', 1);

            // Calcular nuevo nivel
            $newLevel = $this->calculateLevel($user->experience_points);
            $newTier = $this->getCharacterTier($newLevel);
            
            // Actualizar nivel si cambió
            if ($newLevel > $oldLevel) {
                $user->update(['level' => $newLevel]);
                
                // Dar bonus XP por subir de nivel
                $bonusXP = $newLevel * 10;
                $user->increment('experience_points', $bonusXP);
                $xpGained += $bonusXP;
            }

            // Registrar en log si es posible
            try {
                if (class_exists(ExperienceLog::class)) {
                    ExperienceLog::create([
                        'user_id' => $user->_id,
                        'points' => $xpGained,
                        'action' => 'quest_completed',
                        'description' => "Completó misión ID: {$questId}",
                        'source_type' => 'quest',
                        'source_id' => $questId
                    ]);
                }
            } catch (\Exception $e) {
                \Log::warning('Error creating experience log: ' . $e->getMessage());
            }

            // Verificar logros
            $this->checkAchievements($user, 'quest_completed');

            // Verificar si hay evolución de personaje
            $hasEvolution = $newTier > $oldTier;
            
            $response = [
                'success' => true,
                'xp' => $xpGained,
                'old_level' => $oldLevel,
                'new_level' => $newLevel,
                'level_up' => $newLevel > $oldLevel,
                'message' => "¡Misión completada! +{$xpGained} XP ganados"
            ];

            // Si hay evolución, agregar datos especiales
            if ($hasEvolution) {
                $response['evolution'] = true;
                $response['old_tier'] = $oldTier;
                $response['new_tier'] = $newTier;
                $response['tier_name'] = $this->getTierName($newTier);
                $response['character_image'] = $this->getCharacterImage($user->character_type ?? 'mago', $newTier);
                $response['evolution_message'] = $this->getEvolutionMessage($newTier);
                
                // Dar puntos bonus por evolución
                $evolutionBonus = $newTier * 50;
                $user->increment('points', $evolutionBonus);
                $response['evolution_bonus'] = $evolutionBonus;
            }

            return response()->json($response);
            
        } catch (\Exception $e) {
            \Log::error('Error in completeQuest: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al completar la misión'
            ]);
        }
    }

    /**
     * Obtener tier de evolución del personaje
     */
    public function getCharacterTier($level)
    {
        if ($level >= 75) return 4; // Legendario
        if ($level >= 50) return 3; // Épico  
        if ($level >= 25) return 2; // Veterano
        return 1; // Novato
    }

    /**
     * Obtener nombre del tier
     */
    private function getTierName($tier)
    {
        $names = [
            1 => 'Novato',
            2 => 'Veterano', 
            3 => 'Épico',
            4 => 'Legendario'
        ];
        return $names[$tier] ?? 'Novato';
    }

    /**
     * Obtener ruta de imagen del personaje
     */
    private function getCharacterImage($characterType, $tier)
    {
        $characterType = strtolower($characterType);
        $imagePath = "/images/characters/{$characterType}_tier_{$tier}.png";
        
        if (file_exists(public_path($imagePath))) {
            return $imagePath;
        }
        
        // Fallback a imagen genérica
        $fallbackPath = "/images/characters/default_tier_{$tier}.png";
        return file_exists(public_path($fallbackPath)) ? $fallbackPath : null;
    }

    /**
     * Obtener mensaje de evolución
     */
    private function getEvolutionMessage($tier)
    {
        $messages = [
            2 => '¡Tu personaje ha evolucionado a Veterano! Ahora es más fuerte y sabio.',
            3 => '¡Evolución Épica alcanzada! Tu personaje irradia poder y conocimiento.',
            4 => '¡EVOLUCIÓN LEGENDARIA! Tu personaje ha alcanzado la forma más poderosa.'
        ];
        
        return $messages[$tier] ?? '¡Tu personaje ha evolucionado!';
    }

    /**
     * Subir estadística del personaje
     */
    public function upgradeStat(Request $request)
    {
        try {
            $request->validate([
                'stat' => 'required|string|in:strength,intelligence,agility,creativity,leadership,resilience',
                'cost' => 'required|integer|min:1'
            ]);

            $user = Auth::user();
            $statName = $request->stat;
            $cost = $request->cost;

            // Verificar si tiene suficientes puntos
            if (($user->points ?? 0) < $cost) {
                return response()->json([
                    'success' => false,
                    'message' => "No tienes suficientes puntos. Necesitas {$cost} puntos."
                ]);
            }

            // Verificar límite máximo de stat (50)
            $currentStat = $user->{$statName} ?? 10;
            if ($currentStat >= 50) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta estadística ya está al máximo (50)'
                ]);
            }

            // Descontar puntos y subir estadística
            $user->decrement('points', $cost);
            $user->increment($statName, 1);

            // Registrar en log de experiencia si existe
            try {
                if (class_exists(ExperienceLog::class)) {
                    ExperienceLog::create([
                        'user_id' => $user->_id,
                        'points' => -$cost,
                        'action' => 'stat_upgrade',
                        'description' => "Mejoró {$statName} +1",
                        'source_type' => 'upgrade'
                    ]);
                }
            } catch (\Exception $e) {
                \Log::warning('Error creating stat upgrade log: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => "¡{$statName} mejorado exitosamente!",
                'new_value' => $user->{$statName},
                'remaining_points' => $user->points
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in upgradeStat: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al mejorar la estadística'
            ]);
        }
    }

    /**
     * Comprar recompensa
     */
    /**
 * Comprar recompensa - Sistema completo
 */
/**
 * Comprar recompensa - VERSIÓN FUNCIONAL
 */
public function buyReward(Request $request, $rewardId)
{
    try {
        $user = Auth::user();
        
        \Log::info("Attempting to buy reward {$rewardId} for user {$user->email}");
        
        // Lista de recompensas de ejemplo (debe coincidir con las del método store)
        $exampleRewards = [
            1 => ['name' => 'Poción de Sabiduría', 'cost' => 50, 'xp_bonus' => 25],
            2 => ['name' => 'Tiempo Extra de Recreo', 'cost' => 40, 'xp_bonus' => 0],
            3 => ['name' => 'Pergamino de Conocimiento', 'cost' => 75, 'xp_bonus' => 50],
            4 => ['name' => 'Certificado de Honor', 'cost' => 120, 'xp_bonus' => 0],
            5 => ['name' => 'Amuleto de Concentración', 'cost' => 150, 'xp_bonus' => 0],
            6 => ['name' => 'Varita Mágica del Saber', 'cost' => 200, 'xp_bonus' => 100],
            7 => ['name' => 'Escudo del Guerrero', 'cost' => 180, 'xp_bonus' => 0],
            8 => ['name' => 'Corona del Estudiante Épico', 'cost' => 300, 'xp_bonus' => 100]
        ];
        
        // Buscar la recompensa
        $reward = null;
        if (class_exists(Reward::class)) {
            $reward = Reward::find($rewardId);
        }
        
        // Si no existe en BD, usar datos de ejemplo
        if (!$reward && isset($exampleRewards[$rewardId])) {
            $rewardData = $exampleRewards[$rewardId];
            $cost = $rewardData['cost'];
            $rewardName = $rewardData['name'];
            $xpBonus = $rewardData['xp_bonus'];
        } else if ($reward) {
            $cost = $reward->cost_points;
            $rewardName = $reward->name;
            $xpBonus = $reward->xp_bonus ?? 0;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Recompensa no encontrada'
            ]);
        }
        
        // Verificar puntos suficientes
        $userPoints = $user->points ?? 0;
        \Log::info("User has {$userPoints} points, reward costs {$cost}");
        
        if ($userPoints < $cost) {
            return response()->json([
                'success' => false,
                'message' => "No tienes suficientes puntos. Necesitas {$cost} puntos pero solo tienes {$userPoints}."
            ]);
        }
        
        // Procesar la compra
        $user->decrement('points', $cost);
        $user->increment('rewards_earned', 1);
        
        // Aplicar bonus XP si aplica
        if ($xpBonus > 0) {
            $user->increment('experience_points', $xpBonus);
        }
        
        // Crear registro de recompensa si existe el modelo
        try {
            if (class_exists(StudentReward::class) && $reward) {
                StudentReward::create([
                    'student_id' => $user->_id,
                    'reward_id' => $reward->_id,
                    'points_spent' => $cost,
                    'status' => 'delivered',
                    'redeemed_at' => now(),
                    'is_permanent' => $reward->type === 'permanent'
                ]);
            }
        } catch (\Exception $e) {
            \Log::warning('Error creating StudentReward record: ' . $e->getMessage());
        }
        
        // Registrar en log
        try {
            if (class_exists(ExperienceLog::class)) {
                ExperienceLog::create([
                    'user_id' => $user->_id,
                    'points' => -$cost,
                    'action' => 'reward_purchase',
                    'description' => "Canjeó recompensa: {$rewardName}",
                    'source_type' => 'reward',
                    'source_id' => $rewardId
                ]);
                
                if ($xpBonus > 0) {
                    ExperienceLog::create([
                        'user_id' => $user->_id,
                        'points' => $xpBonus,
                        'action' => 'reward_bonus',
                        'description' => "Bonus XP de recompensa: {$rewardName}",
                        'source_type' => 'reward',
                        'source_id' => $rewardId
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Error creating experience log: ' . $e->getMessage());
        }
        
        $response = [
            'success' => true,
            'message' => "¡{$rewardName} canjeada con éxito!",
            'points_spent' => $cost,
            'remaining_points' => $user->points,
            'reward_name' => $rewardName
        ];
        
        if ($xpBonus > 0) {
            $response['xp_gained'] = $xpBonus;
            $response['message'] .= " +{$xpBonus} XP ganados!";
        }
        
        \Log::info("Reward purchase successful: " . json_encode($response));
        
        return response()->json($response);
        
    } catch (\Exception $e) {
        \Log::error('Error in buyReward: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error interno al canjear la recompensa'
        ]);
    }
}

/**
 * Obtener razón por la cual no se puede canjear una recompensa
 */
private function getRedemptionErrorReason(Reward $reward, User $user)
{
    if ($reward->level_requirement && $user->level < $reward->level_requirement) {
        return "Necesitas ser nivel {$reward->level_requirement} para esta recompensa.";
    }

    if ($reward->character_specific && !in_array($user->character_type, $reward->character_specific)) {
        $allowedTypes = implode(', ', $reward->character_specific);
        return "Esta recompensa es exclusiva para: {$allowedTypes}.";
    }

    if ($reward->max_uses_per_student) {
        $usedCount = StudentReward::where('student_id', $user->_id)
                                 ->where('reward_id', $reward->_id)
                                 ->whereIn('status', ['approved', 'delivered'])
                                 ->count();
        
        if ($usedCount >= $reward->max_uses_per_student) {
            return "Ya alcanzaste el límite máximo de esta recompensa.";
        }
    }

    if (!$reward->is_active) {
        return "Esta recompensa no está disponible actualmente.";
    }

    if ($reward->stock_quantity !== null && $reward->stock_quantity <= 0) {
        return "Esta recompensa está agotada.";
    }

    return "No puedes canjear esta recompensa en este momento.";
}

    /**
     * Calcular nivel basado en XP
     */
    private function calculateLevel($xp)
    {
        return (int) floor(sqrt($xp / 100)) + 1;
    }

    /**
     * Verificar y desbloquear logros
     */
    private function checkAchievements($user, $action)
    {
        try {
            if (!class_exists(Achievement::class)) return;

            $achievements = [
                'first_quest' => [
                    'condition' => ($user->quests_completed ?? 0) >= 1,
                    'name' => 'Primera Misión',
                    'description' => 'Completaste tu primera misión',
                    'icon' => '🗡️',
                    'xp' => 25
                ],
                'quest_5' => [
                    'condition' => ($user->quests_completed ?? 0) >= 5,
                    'name' => 'Aventurero Dedicado',
                    'description' => 'Completaste 5 misiones',
                    'icon' => '🎯',
                    'xp' => 50
                ],
                'quest_master' => [
                    'condition' => ($user->quests_completed ?? 0) >= 10,
                    'name' => 'Maestro de Misiones',
                    'description' => 'Completaste 10 misiones',
                    'icon' => '🏆',
                    'xp' => 100
                ],
                'level_5' => [
                    'condition' => ($user->level ?? 1) >= 5,
                    'name' => 'Aventurero Experimentado',
                    'description' => 'Alcanzaste el nivel 5',
                    'icon' => '⭐',
                    'xp' => 75
                ],
                'level_10' => [
                    'condition' => ($user->level ?? 1) >= 10,
                    'name' => 'Héroe Veterano',
                    'description' => 'Alcanzaste el nivel 10',
                    'icon' => '🌟',
                    'xp' => 150
                ],
                'level_25' => [
                    'condition' => ($user->level ?? 1) >= 25,
                    'name' => 'Leyenda Ascendente',
                    'description' => 'Alcanzaste el nivel 25 - Primera Evolución',
                    'icon' => '👑',
                    'xp' => 250
                ],
                'level_50' => [
                    'condition' => ($user->level ?? 1) >= 50,
                    'name' => 'Héroe Épico',
                    'description' => 'Alcanzaste el nivel 50 - Evolución Épica',
                    'icon' => '💫',
                    'xp' => 500
                ],
                'level_75' => [
                    'condition' => ($user->level ?? 1) >= 75,
                    'name' => 'Leyenda Legendaria',
                    'description' => 'Alcanzaste el nivel 75 - Evolución Legendaria',
                    'icon' => '💎',
                    'xp' => 1000
                ]
            ];

            foreach ($achievements as $key => $achievement) {
                if (Achievement::where('user_id', $user->_id)->where('key', $key)->exists()) {
                    continue;
                }

                if ($achievement['condition']) {
                    Achievement::create([
                        'user_id' => $user->_id,
                        'key' => $key,
                        'name' => $achievement['name'],
                        'description' => $achievement['description'],
                        'icon' => $achievement['icon'],
                        'xp_reward' => $achievement['xp'],
                        'unlocked_at' => now()
                    ]);

                    $user->increment('experience_points', $achievement['xp']);
                    $user->increment('achievements_count', 1);

                    if (class_exists(ExperienceLog::class)) {
                        ExperienceLog::create([
                            'user_id' => $user->_id,
                            'points' => $achievement['xp'],
                            'action' => 'achievement_unlock',
                            'description' => "Logro desbloqueado: {$achievement['name']}",
                            'source_type' => 'achievement'
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Error checking achievements: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar aula específica
     */
    /**
 * Mostrar aula específica
 */
public function showClassroom($id)
{
    // AGREGAR ESTOS LOGS PARA DEBUG
    \Log::info('showClassroom method called with ID: ' . $id);
    \Log::info('User: ' . Auth::user()->email);
    try {
        $classroom = Classroom::findOrFail($id);
        $user = Auth::user();
        
        // Verificar que el estudiante esté en el aula
        if (!in_array($user->_id, $classroom->student_ids ?? [])) {
            return redirect()->route('students.dashboard')
                ->with('error', 'No tienes acceso a esta aula');
        }
        
        return view('students.classroom.show', compact('classroom'));
        
    } catch (\Exception $e) {
        \Log::error('Error in showClassroom: ' . $e->getMessage());
        return redirect()->route('students.dashboard')
            ->with('error', 'No se pudo acceder al aula');
    }
}

    /**
     * Vista para unirse a aula
     */
    public function joinClassroom()
    {
        return view('students.join-classroom');
    }

    /**
     * Procesar unirse a aula
     */
    /**
 * Procesar unirse a aula
 */
public function processJoin(Request $request)
{
    try {
        $request->validate([
            'code' => 'required|string|min:3'
        ]);

        // Debug: Log del código recibido
        \Log::info('Intentando unirse con código: ' . $request->code);

        $classroom = Classroom::where('class_code', $request->code)->first();
        
        if (!$classroom) {
            \Log::warning('Código no encontrado: ' . $request->code);
            return back()->withErrors(['code' => 'Código de aula inválido']);
        }

        \Log::info('Aula encontrada: ' . $classroom->name);

        $userId = Auth::id();
        $studentIds = $classroom->student_ids ?? [];

        if (in_array($userId, $studentIds)) {
            return redirect()->route('students.classroom.show', $classroom->_id)
                ->with('message', 'Ya formas parte de esta aula');
        }

        $studentIds[] = $userId;
        $classroom->update(['student_ids' => $studentIds]);

        return redirect()->route('students.dashboard')
            ->with('success', '¡Te has unido exitosamente al aula: ' . $classroom->name . '!');
            
    } catch (\Exception $e) {
        \Log::error('Error in processJoin: ' . $e->getMessage());
        return back()->with('error', 'Error al unirse al aula');
    }
}

    /**
     * Ver logros del estudiante
     */
    public function myAchievements()
    {
        try {
            $achievements = collect();
            
            if (class_exists(Achievement::class)) {
                $achievements = Achievement::where('user_id', Auth::id())
                    ->orderBy('unlocked_at', 'desc')
                    ->get();
            }
                
            return view('students.achievements', compact('achievements'));
            
        } catch (\Exception $e) {
            \Log::error('Error in myAchievements: ' . $e->getMessage());
            return view('students.achievements', ['achievements' => collect()]);
        }
    }

    /**
 * Obtener el historial de recompensas del estudiante
 */
public function myRewards()
{
    try {
        $user = Auth::user();
        $myRewards = collect();
        
        if (class_exists(StudentReward::class)) {
            $myRewards = StudentReward::where('student_id', $user->_id)
                ->with(['reward', 'classroom'])
                ->orderBy('redeemed_at', 'desc')
                ->get();
        }
        
        // Estadísticas
        $stats = [
            'total_spent' => $myRewards->sum('points_spent'),
            'total_rewards' => $myRewards->count(),
            'pending_rewards' => $myRewards->where('status', 'pending')->count(),
            'active_rewards' => $myRewards->filter(function($reward) {
                return $reward->isActive();
            })->count()
        ];
        
        return view('students.my-rewards', compact('myRewards', 'stats'));
        
    } catch (\Exception $e) {
        \Log::error('Error in myRewards: ' . $e->getMessage());
        return view('students.my-rewards', [
            'myRewards' => collect(),
            'stats' => ['total_spent' => 0, 'total_rewards' => 0, 'pending_rewards' => 0, 'active_rewards' => 0]
        ]);
    }
}

    /**
     * Seleccionar personaje
     */
    public function selectCharacter(Request $request)
    {
        try {
            $request->validate([
                'character_type' => 'required|string|in:mage,warrior,ninja,archer,launcher'
            ]);

            $user = Auth::user();
            $characterType = $request->character_type;

            // Definir datos de personajes
            $characters = [
                'mage' => [
                    'class' => 'Mago Sabio',
                    'icon' => '🧙‍♂️',
                    'bonus_type' => 'knowledge'
                ],
                'warrior' => [
                    'class' => 'Guerrero Valiente',
                    'icon' => '⚔️',
                    'bonus_type' => 'strength'
                ],
                'ninja' => [
                    'class' => 'Ninja Ágil',
                    'icon' => '🥷',
                    'bonus_type' => 'agility'
                ],
                'archer' => [
                    'class' => 'Arquero Preciso',
                    'icon' => '🏹',
                    'bonus_type' => 'precision'
                ],
                'launcher' => [
                    'class' => 'Lanzador Creativo',
                    'icon' => '🎯',
                    'bonus_type' => 'creativity'
                ]
            ];

            if (!isset($characters[$characterType])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tipo de personaje inválido'
                ]);
            }

            $character = $characters[$characterType];

            // Actualizar datos del usuario
            $user->update([
                'character_type' => $characterType,
                'character_class' => $character['class'],
                'character_icon' => $character['icon'],
                'character_bonus_type' => $character['bonus_type'],
                'first_character_selection' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Personaje seleccionado exitosamente!',
                'character' => $character
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in selectCharacter: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al seleccionar personaje'
            ]);
        }
    }

    /**
     * Obtener progreso del estudiante
     */
    public function getProgress()
    {
        try {
            $user = Auth::user();
            
            return response()->json([
                'level' => $user->level ?? 1,
                'xp' => $user->experience_points ?? 0,
                'next_level_xp' => $user->getNextLevelXP(),
                'progress_percentage' => $user->getCurrentLevelProgress(),
                'points' => $user->points ?? 0,
                'quests_completed' => $user->quests_completed ?? 0,
                'achievements_count' => $user->achievements_count ?? 0
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getProgress: ' . $e->getMessage());
            return response()->json([
                'level' => 1,
                'xp' => 0,
                'next_level_xp' => 100,
                'progress_percentage' => 0,
                'points' => 0,
                'quests_completed' => 0,
                'achievements_count' => 0
            ]);
        }
    }

    /**
     * Obtener información del personaje
     */
    public function getCharacterInfo()
    {
        try {
            $user = Auth::user();
            
            return response()->json([
                'character_class' => $user->character_class ?? 'Aventurero',
                'character_icon' => $user->character_icon ?? '⚔️',
                'character_type' => $user->character_type ?? 'mago',
                'character_bonus_type' => $user->character_bonus_type ?? 'knowledge',
                'level' => $user->level ?? 1,
                'tier' => $this->getCharacterTier($user->level ?? 1),
                'first_selection' => $user->first_character_selection ?? false
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getCharacterInfo: ' . $e->getMessage());
            return response()->json([
                'character_class' => 'Aventurero',
                'character_icon' => '⚔️',
                'character_type' => 'mago',
                'character_bonus_type' => 'knowledge',
                'level' => 1,
                'tier' => 1,
                'first_selection' => false
            ]);
        }
    }

    /**
     * Perfil del estudiante
     */
    public function profile()
    {
        try {
            $user = Auth::user();
            
            return view('students.profile', compact('user'));
            
        } catch (\Exception $e) {
            \Log::error('Error in profile: ' . $e->getMessage());
            return redirect()->route('students.dashboard')
                ->with('error', 'Error al cargar el perfil');
        }
    }

   /**
 * Mostrar página de selección de personaje
 */
public function characterSelect()
{
    $user = Auth::user();
    
    // Si ya seleccionó personaje, redirigir al dashboard
    if ($user->first_character_selection) {
        return redirect()->route('students.dashboard');
    }
    
    // Definir personajes disponibles
    $characters = [
        'mage' => [
            'name' => 'Mago Sabio',
            'description' => 'Maestro del conocimiento y la sabiduría. Obtiene bonus extra en tareas académicas.',
            'icon' => '🧙‍♂️',
            'bonus_type' => 'knowledge',
            'bonus_description' => '+20% XP en tareas de estudio',
            'stats' => ['Inteligencia: ⭐⭐⭐⭐⭐', 'Sabiduría: ⭐⭐⭐⭐⭐', 'Creatividad: ⭐⭐⭐'],
            'color' => 'from-blue-400 to-purple-600'
        ],
        'warrior' => [
            'name' => 'Guerrero Valiente',
            'description' => 'Fuerte y determinado. Perfecto para enfrentar desafíos difíciles.',
            'icon' => '⚔️',
            'bonus_type' => 'strength',
            'bonus_description' => '+20% XP en proyectos desafiantes',
            'stats' => ['Fuerza: ⭐⭐⭐⭐⭐', 'Resistencia: ⭐⭐⭐⭐⭐', 'Liderazgo: ⭐⭐⭐⭐'],
            'color' => 'from-red-400 to-orange-600'
        ],
        'ninja' => [
            'name' => 'Ninja Ágil',
            'description' => 'Rápido y preciso. Excelente para completar tareas con velocidad.',
            'icon' => '🥷',
            'bonus_type' => 'agility',
            'bonus_description' => '+20% XP en entregas rápidas',
            'stats' => ['Agilidad: ⭐⭐⭐⭐⭐', 'Precisión: ⭐⭐⭐⭐', 'Sigilo: ⭐⭐⭐⭐⭐'],
            'color' => 'from-gray-700 to-purple-800'
        ],
        'archer' => [
            'name' => 'Arquero Preciso',
            'description' => 'Enfocado y preciso. Ideal para tareas que requieren atención al detalle.',
            'icon' => '🏹',
            'bonus_type' => 'precision',
            'bonus_description' => '+20% XP en trabajos detallados',
            'stats' => ['Precisión: ⭐⭐⭐⭐⭐', 'Concentración: ⭐⭐⭐⭐⭐', 'Paciencia: ⭐⭐⭐⭐'],
            'color' => 'from-green-400 to-emerald-600'
        ],
        'launcher' => [
            'name' => 'Lanzador Creativo',
            'description' => 'Creativo e innovador. Perfecto para proyectos artísticos y creativos.',
            'icon' => '🎯',
            'bonus_type' => 'creativity',
            'bonus_description' => '+20% XP en proyectos creativos',
            'stats' => ['Creatividad: ⭐⭐⭐⭐⭐', 'Innovación: ⭐⭐⭐⭐⭐', 'Inspiración: ⭐⭐⭐⭐'],
            'color' => 'from-yellow-400 to-pink-600'
        ]
    ];
    
    return view('students.character.select', compact('characters'));
}
/**
 * Mostrar la tienda de recompensas
 */
   /**
 * Mostrar la tienda de recompensas
 */
public function store()
{
    try {
        $user = Auth::user();
        $availableRewards = collect();
        $myRewards = collect();
        
        // Obtener recompensas disponibles
        if (class_exists(Reward::class)) {
            $availableRewards = Reward::where('is_active', true)
                ->orderBy('cost_points', 'asc')
                ->get();
        }
        
        // Si no hay recompensas reales, mostrar datos de ejemplo
        if ($availableRewards->isEmpty()) {
            $availableRewards = collect([
                (object)[
                    'id' => 1,
                    '_id' => '1',
                    'name' => 'Poción de Sabiduría',
                    'description' => 'Aumenta tu experiencia en las próximas 3 tareas',
                    'icon' => '🧪',
                    'cost_points' => 50,
                    'cost' => 50,
                    'rarity' => 'common',
                    'type' => 'temporary',
                    'xp_bonus' => 25,
                    'duration_hours' => 24,
                    'level_requirement' => 1,
                    'character_specific' => [],
                    'is_active' => true
                ],
                (object)[
                    'id' => 2,
                    '_id' => '2',
                    'name' => 'Tiempo Extra de Recreo',
                    'description' => '15 minutos adicionales de recreo por una semana',
                    'icon' => '🎮',
                    'cost_points' => 40,
                    'cost' => 40,
                    'rarity' => 'common',
                    'type' => 'privilege',
                    'duration_hours' => 168,
                    'level_requirement' => 1,
                    'character_specific' => [],
                    'is_active' => true
                ],
                (object)[
                    'id' => 3,
                    '_id' => '3',
                    'name' => 'Pergamino de Conocimiento',
                    'description' => 'Desbloquea pistas especiales para resolver problemas',
                    'icon' => '📜',
                    'cost_points' => 75,
                    'cost' => 75,
                    'rarity' => 'rare',
                    'type' => 'instant',
                    'xp_bonus' => 50,
                    'level_requirement' => 5,
                    'character_specific' => [],
                    'is_active' => true
                ],
                (object)[
                    'id' => 4,
                    '_id' => '4',
                    'name' => 'Certificado de Honor',
                    'description' => 'Un certificado personalizado que reconoce tu esfuerzo',
                    'icon' => '🏆',
                    'cost_points' => 120,
                    'cost' => 120,
                    'rarity' => 'rare',
                    'type' => 'physical',
                    'level_requirement' => 8,
                    'character_specific' => [],
                    'is_active' => true
                ],
                (object)[
                    'id' => 5,
                    '_id' => '5',
                    'name' => 'Amuleto de Concentración',
                    'description' => 'Mejora permanentemente tu estadística de Inteligencia',
                    'icon' => '🔮',
                    'cost_points' => 150,
                    'cost' => 150,
                    'rarity' => 'epic',
                    'type' => 'permanent',
                    'stat_bonuses' => ['intelligence' => 2],
                    'level_requirement' => 10,
                    'character_specific' => [],
                    'is_active' => true
                ],
                (object)[
                    'id' => 6,
                    '_id' => '6',
                    'name' => 'Varita Mágica del Saber',
                    'description' => 'Solo para magos: Duplica la experiencia por 2 días',
                    'icon' => '🪄',
                    'cost_points' => 200,
                    'cost' => 200,
                    'rarity' => 'epic',
                    'type' => 'temporary',
                    'character_specific' => ['mago'],
                    'xp_bonus' => 100,
                    'duration_hours' => 48,
                    'level_requirement' => 15,
                    'is_active' => true
                ],
                (object)[
                    'id' => 7,
                    '_id' => '7',
                    'name' => 'Escudo del Guerrero',
                    'description' => 'Solo para guerreros: Protección contra penalizaciones',
                    'icon' => '🛡️',
                    'cost_points' => 180,
                    'cost' => 180,
                    'rarity' => 'epic',
                    'type' => 'temporary',
                    'character_specific' => ['guerrero'],
                    'duration_hours' => 72,
                    'level_requirement' => 12,
                    'is_active' => true
                ],
                (object)[
                    'id' => 8,
                    '_id' => '8',
                    'name' => 'Corona del Estudiante Épico',
                    'description' => 'Título especial que te otorga respeto y bonificaciones',
                    'icon' => '👑',
                    'cost_points' => 300,
                    'cost' => 300,
                    'rarity' => 'legendary',
                    'type' => 'permanent',
                    'xp_bonus' => 100,
                    'stat_bonuses' => ['leadership' => 5, 'intelligence' => 3],
                    'level_requirement' => 20,
                    'character_specific' => [],
                    'is_active' => true
                ]
            ]);
        }
        
        // Obtener recompensas del estudiante
        if (class_exists(StudentReward::class)) {
            $myRewards = StudentReward::where('student_id', $user->_id)
                ->with('reward')
                ->orderBy('redeemed_at', 'desc')
                ->limit(6)
                ->get();
        }
        
        return view('students.store', compact('availableRewards', 'myRewards'));
        
    } catch (\Exception $e) {
        \Log::error('Error in store: ' . $e->getMessage());
        return view('students.store', [
            'availableRewards' => collect(),
            'myRewards' => collect()
        ]);
    }
}
/**
 * Obtener recompensas por categoría (AJAX)
 */
public function getRewardsByCategory(Request $request)
{
    try {
        $category = $request->get('category', 'all');
        $user = Auth::user();
        
        if (!class_exists(Reward::class)) {
            return response()->json(['rewards' => []]);
        }
        
        $query = Reward::where('is_active', true);
        
        switch ($category) {
            case 'affordable':
                $query->where('cost_points', '<=', $user->points ?? 0);
                break;
            case 'character_specific':
                if ($user->character_type) {
                    $query->where(function($q) use ($user) {
                        $q->whereNull('character_specific')
                          ->orWhere('character_specific', 'all', [$user->character_type]);
                    });
                }
                break;
            case 'temporary':
                $query->where('type', 'temporary');
                break;
            case 'permanent':
                $query->where('type', 'permanent');
                break;
            default:
                if ($category !== 'all') {
                    $query->where('rarity', $category);
                }
                break;
        }
        
        $rewards = $query->orderBy('cost_points', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'rewards' => $rewards->map(function($reward) use ($user) {
                return [
                    'id' => $reward->_id,
                    'name' => $reward->name,
                    'description' => $reward->description,
                    'icon' => $reward->icon,
                    'cost_points' => $reward->cost_points,
                    'rarity' => $reward->rarity,
                    'can_afford' => ($user->points ?? 0) >= $reward->cost_points,
                    'can_redeem' => $reward->canBeRedeemedBy($user)
                ];
            })
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error in getRewardsByCategory: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener recompensas'
        ]);
    }
}

    /**
     * Historial de recompensas del estudiante
     */
    public function rewardsHistory()
    {
        try {
            $user = Auth::user();
            $rewards = collect();
            $activeRewards = collect();

            if (class_exists(\App\Models\StudentReward::class)) {
                $rewards = \App\Models\StudentReward::where('student_id', $user->_id)
                    ->with('reward')
                    ->orderBy('redeemed_at', 'desc')
                    ->get();
                $activeRewards = $rewards->filter(fn($r) => ($r->status ?? '') === 'active');
            }

            return view('students.rewards', compact('rewards', 'activeRewards'));

        } catch (\Exception $e) {
            \Log::error('Error in rewardsHistory: ' . $e->getMessage());
            return view('students.rewards', ['rewards' => collect(), 'activeRewards' => collect()]);
        }
    }
}