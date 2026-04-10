<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ExperienceLog;
use App\Models\Achievement;

class CharacterController extends Controller
{
    /**
     * Mostrar perfil del personaje
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Obtener estadísticas del personaje
        $characterStats = $this->getCharacterStats($user);
        $evolutionData = $this->getEvolutionData($user);
        $experienceHistory = $this->getExperienceHistory($user);
        $characterAchievements = $this->getCharacterAchievements($user);
        
        return view('students.character.profile', compact(
            'user',
            'characterStats',
            'evolutionData', 
            'experienceHistory',
            'characterAchievements'
        ));
    }

    /**
     * Obtener estadísticas del personaje
     */
    private function getCharacterStats($user)
    {
        $level = $user->level ?? 1;
        $tier = $this->getCharacterTier($level);
        
        return [
            'level' => $level,
            'tier' => $tier,
            'tier_name' => $this->getTierName($tier),
            'experience_points' => $user->experience_points ?? 0,
            'next_level_xp' => $this->getNextLevelXP($level),
            'current_level_xp' => $this->getCurrentLevelXP($level),
            'progress_percentage' => $this->getLevelProgress($user),
            'next_evolution' => $this->getNextEvolution($level),
            'stats' => [
                'strength' => $this->calculateStat('strength', $level, $user->character_bonus_type),
                'intelligence' => $this->calculateStat('intelligence', $level, $user->character_bonus_type),
                'agility' => $this->calculateStat('agility', $level, $user->character_bonus_type),
                'creativity' => $this->calculateStat('creativity', $level, $user->character_bonus_type),
                'leadership' => $this->calculateStat('leadership', $level, $user->character_bonus_type),
                'resilience' => $this->calculateStat('resilience', $level, $user->character_bonus_type)
            ],
            'total_power' => $this->calculateTotalPower($level, $user->character_bonus_type)
        ];
    }

    /**
     * Obtener datos de evolución
     */
    private function getEvolutionData($user)
    {
        $level = $user->level ?? 1;
        $evolutions = [];
        
        for ($tier = 1; $tier <= 4; $tier++) {
            $requiredLevel = ($tier - 1) * 25 + 1;
            $isUnlocked = $level >= $requiredLevel;
            $isCurrent = $this->getCharacterTier($level) == $tier;
            
            $evolutions[] = [
                'tier' => $tier,
                'name' => $this->getTierName($tier),
                'required_level' => $requiredLevel,
                'is_unlocked' => $isUnlocked,
                'is_current' => $isCurrent,
                'image' => $this->getTierImage($user->character_type, $tier),
                'description' => $this->getTierDescription($tier),
                'bonus_stats' => $this->getTierBonusStats($tier)
            ];
        }
        
        return $evolutions;
    }

    /**
     * Obtener historial de experiencia
     */
    private function getExperienceHistory($user)
    {
        try {
            if (class_exists(ExperienceLog::class)) {
                return ExperienceLog::where('user_id', $user->_id)
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();
            }
        } catch (\Exception $e) {
            \Log::warning('Error loading experience history: ' . $e->getMessage());
        }
        
        return collect();
    }

    /**
     * Obtener logros del personaje
     */
    private function getCharacterAchievements($user)
    {
        try {
            if (class_exists(Achievement::class)) {
                return Achievement::where('user_id', $user->_id)
                    ->orderBy('unlocked_at', 'desc')
                    ->get();
            }
        } catch (\Exception $e) {
            \Log::warning('Error loading achievements: ' . $e->getMessage());
        }
        
        return collect();
    }

    /**
     * Calcular tier del personaje (1-4)
     */
    private function getCharacterTier($level)
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
     * Obtener imagen del tier
     */
    private function getTierImage($characterType, $tier)
    {
        $characterType = $characterType ?? 'guerrero';
        return "/images/characters/{$characterType}_tier_{$tier}.png";
    }

    /**
     * Obtener descripción del tier
     */
    private function getTierDescription($tier)
    {
        $descriptions = [
            1 => 'Un aventurero que comienza su legendaria jornada',
            2 => 'Un guerrero experimentado con habilidades probadas',
            3 => 'Un héroe épico cuya fama se extiende por todas las tierras',
            4 => 'Una leyenda viviente cuyo poder trasciende lo mortal'
        ];
        
        return $descriptions[$tier] ?? '';
    }

    /**
     * Obtener bonus de stats por tier
     */
    private function getTierBonusStats($tier)
    {
        $bonuses = [
            1 => 0,
            2 => 25,
            3 => 50, 
            4 => 100
        ];
        
        return $bonuses[$tier] ?? 0;
    }

    /**
     * Calcular estadística específica
     */
    private function calculateStat($statType, $level, $bonusType)
    {
        $baseStat = 10 + ($level * 2);
        $tierBonus = $this->getTierBonusStats($this->getCharacterTier($level));
        
        // Aplicar bonus del tipo de personaje
        $typeBonus = 0;
        $bonusMap = [
            'knowledge' => ['intelligence' => 1.5],
            'strength' => ['strength' => 1.5, 'resilience' => 1.2],
            'agility' => ['agility' => 1.5],
            'precision' => ['intelligence' => 1.2, 'agility' => 1.2],
            'creativity' => ['creativity' => 1.5, 'intelligence' => 1.2]
        ];
        
        if (isset($bonusMap[$bonusType][$statType])) {
            $typeBonus = $baseStat * ($bonusMap[$bonusType][$statType] - 1);
        }
        
        return (int) ($baseStat + $tierBonus + $typeBonus);
    }

    /**
     * Calcular poder total
     */
    private function calculateTotalPower($level, $bonusType)
    {
        $stats = [
            'strength' => $this->calculateStat('strength', $level, $bonusType),
            'intelligence' => $this->calculateStat('intelligence', $level, $bonusType),
            'agility' => $this->calculateStat('agility', $level, $bonusType),
            'creativity' => $this->calculateStat('creativity', $level, $bonusType),
            'leadership' => $this->calculateStat('leadership', $level, $bonusType),
            'resilience' => $this->calculateStat('resilience', $level, $bonusType)
        ];
        
        return array_sum($stats);
    }

    /**
     * Obtener XP necesario para siguiente nivel
     */
    private function getNextLevelXP($level)
    {
        return ($level * $level) * 100;
    }

    /**
     * Obtener XP del nivel actual
     */
    private function getCurrentLevelXP($level)
    {
        return $level > 1 ? (($level - 1) * ($level - 1)) * 100 : 0;
    }

    /**
     * Obtener progreso del nivel actual
     */
    private function getLevelProgress($user)
    {
        $currentXP = $user->experience_points ?? 0;
        $currentLevelXP = $this->getCurrentLevelXP($user->level ?? 1);
        $nextLevelXP = $this->getNextLevelXP($user->level ?? 1);
        
        if ($nextLevelXP <= $currentLevelXP) return 100;
        
        return min(100, (($currentXP - $currentLevelXP) / ($nextLevelXP - $currentLevelXP)) * 100);
    }

    /**
     * Obtener próxima evolución
     */
    private function getNextEvolution($level)
    {
        $nextTierLevel = 25;
        if ($level >= 75) return null; // Ya es máximo nivel
        if ($level >= 50) $nextTierLevel = 75;
        else if ($level >= 25) $nextTierLevel = 50;
        
        return [
            'level' => $nextTierLevel,
            'levels_remaining' => $nextTierLevel - $level,
            'tier' => $this->getCharacterTier($nextTierLevel),
            'tier_name' => $this->getTierName($this->getCharacterTier($nextTierLevel))
        ];
    }

    /**
     * API para obtener datos del personaje
     */
    public function getCharacterData()
    {
        $user = Auth::user();
        $characterStats = $this->getCharacterStats($user);
        
        return response()->json([
            'success' => true,
            'character' => [
                'name' => $user->name,
                'class' => $user->character_class,
                'icon' => $user->character_icon ?? '⚔️',
                'type' => $user->character_type,
                'level' => $characterStats['level'],
                'tier' => $characterStats['tier'],
                'tier_name' => $characterStats['tier_name'],
                'experience_points' => $characterStats['experience_points'],
                'progress_percentage' => $characterStats['progress_percentage'],
                'stats' => $characterStats['stats'],
                'total_power' => $characterStats['total_power']
            ]
        ]);
    }
}