<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'achievements';

    protected $fillable = [
        'user_id',
        'key',
        'name',
        'description',
        'icon',
        'xp_reward',
        'rarity',
        'category',
        'unlocked_at',
        'progress',
        'max_progress',
        'is_completed',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'xp_reward' => 'integer',
        'unlocked_at' => 'datetime',
        'progress' => 'integer',
        'max_progress' => 'integer',
        'is_completed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $attributes = [
        'progress' => 0,
        'is_completed' => false,
        'rarity' => 'common'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProgressPercentage()
    {
        if (!$this->max_progress) return 100;
        return min(100, ($this->progress / $this->max_progress) * 100);
    }

    public function getRarityColor()
    {
        $colors = [
            'common' => 'text-gray-600',
            'rare' => 'text-blue-600', 
            'epic' => 'text-purple-600',
            'legendary' => 'text-yellow-600'
        ];

        return $colors[$this->rarity] ?? 'text-gray-600';
    }
}
