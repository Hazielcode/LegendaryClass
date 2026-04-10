<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'rewards';
    
    protected $fillable = [
        'name',
        'description',
        'cost_points',
        'type',
        'icon',
        'classroom_id',
        'is_active',
        'stock_quantity',
        'requirements',
        'created_by',
        'reward_type',
        'xp_bonus',
        'stat_bonuses',
        'level_requirement',
        'character_specific',
        'duration_hours',
        'max_uses_per_student',
        'rarity',
        'effect_description',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'cost_points' => 'integer',
        'is_active' => 'boolean',
        'stock_quantity' => 'integer',
        'requirements' => 'array',
        'xp_bonus' => 'integer',
        'stat_bonuses' => 'array',
        'level_requirement' => 'integer',
        'character_specific' => 'array',
        'duration_hours' => 'integer',
        'max_uses_per_student' => 'integer'
    ];
    
    protected $attributes = [
        'is_active' => true,
        'xp_bonus' => 0,
        'level_requirement' => 1,
        'rarity' => 'common'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function studentRewards()
    {
        return $this->hasMany(StudentReward::class, 'reward_id');
    }

    public function canBeRedeemedBy(User $student)
    {
        if ($this->level_requirement && $student->level < $this->level_requirement) {
            return false;
        }
        
        if ($this->character_specific && !in_array($student->character_type, $this->character_specific)) {
            return false;
        }
        
        if ($this->max_uses_per_student) {
            $usedCount = $this->studentRewards()
                             ->where('student_id', $student->id)
                             ->whereIn('status', ['approved', 'delivered'])
                             ->count();
            
            if ($usedCount >= $this->max_uses_per_student) {
                return false;
            }
        }
        
        return $this->is_active && ($this->stock_quantity === null || $this->stock_quantity > 0);
    }

    // MÃ©todos de estilo existentes
    public function getRarityColor()
    {
        $colors = [
            'common' => 'text-gray-400',
            'rare' => 'text-blue-400',
            'epic' => 'text-purple-400',
            'legendary' => 'text-yellow-400'
        ];
        return $colors[$this->rarity] ?? 'text-gray-400';
    }

    public function getRarityBorder()
    {
        $borders = [
            'common' => 'border-gray-500/30',
            'rare' => 'border-blue-500/50',
            'epic' => 'border-purple-500/50',
            'legendary' => 'border-yellow-500/50'
        ];
        return $borders[$this->rarity] ?? 'border-gray-500/30';
    }

    // MÃ©todos de estilo para la nueva vista
    public function getRarityBorderClass()
    {
        $borders = [
            'common' => 'border-l-4 border-gray-400',
            'rare' => 'border-l-4 border-blue-500',
            'epic' => 'border-l-4 border-purple-500',
            'legendary' => 'border-l-4 border-yellow-500'
        ];
        return $borders[$this->rarity] ?? 'border-l-4 border-gray-400';
    }

    public function getRarityHeaderBg()
    {
        $backgrounds = [
            'common' => 'bg-gray-50',
            'rare' => 'bg-blue-50',
            'epic' => 'bg-purple-50',
            'legendary' => 'bg-yellow-50'
        ];
        return $backgrounds[$this->rarity] ?? 'bg-gray-50';
    }

    public function getRarityTextColor()
    {
        $colors = [
            'common' => 'text-gray-700',
            'rare' => 'text-blue-700',
            'epic' => 'text-purple-700',
            'legendary' => 'text-yellow-700'
        ];
        return $colors[$this->rarity] ?? 'text-gray-700';
    }

    public function getRarityBadgeBg()
    {
        $backgrounds = [
            'common' => 'bg-gray-100',
            'rare' => 'bg-blue-100',
            'epic' => 'bg-purple-100',
            'legendary' => 'bg-yellow-100'
        ];
        return $backgrounds[$this->rarity] ?? 'bg-gray-100';
    }

    public function applyToStudent(User $student)
    {
        $effects = [];
        
        if ($this->xp_bonus > 0) {
            $result = $student->gainExperience(
                $this->xp_bonus, 
                'reward', 
                "Recompensa: {$this->name}"
            );
            $effects['xp'] = $result;
        }
        
        if ($this->stat_bonuses) {
            foreach ($this->stat_bonuses as $stat => $bonus) {
                $student->increment($stat, $bonus);
            }
            $effects['stats'] = $this->stat_bonuses;
        }
        
        return $effects;
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
            return "Ya alcanzaste el lÃ­mite mÃ¡ximo de esta recompensa.";
        }
    }

    if (!$reward->is_active) {
        return "Esta recompensa no estÃ¡ disponible.";
    }

    if ($reward->stock_quantity !== null && $reward->stock_quantity <= 0) {
        return "Esta recompensa estÃ¡ agotada.";
    }

    return "No puedes canjear esta recompensa.";
}
}
