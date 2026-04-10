<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class StudentReward extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'student_rewards';

    protected $fillable = [
        'student_id',
        'reward_id',
        'classroom_id',
        'points_spent',
        'status',
        'redeemed_at',
        'approved_by',
        'approved_at',
        'notes',
        'effects_applied',
        'expires_at',
        'is_permanent',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'points_spent' => 'integer',
        'redeemed_at' => 'datetime',
        'approved_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_permanent' => 'boolean',
        'effects_applied' => 'array'
    ];

    protected $attributes = [
        'status' => 'pending',
        'is_permanent' => false
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isActive()
    {
        if ($this->is_permanent) return true;
        if (!$this->expires_at) return false;
        
        return $this->expires_at->isFuture();
    }

    public function getStatusColor()
    {
        $colors = [
            'pending' => 'text-yellow-600 bg-yellow-100',
            'approved' => 'text-green-600 bg-green-100',
            'delivered' => 'text-blue-600 bg-blue-100',
            'cancelled' => 'text-red-600 bg-red-100'
        ];

        return $colors[$this->status] ?? 'text-gray-600 bg-gray-100';
    }

    public function getStatusText()
    {
        $texts = [
            'pending' => 'Pendiente',
            'approved' => 'Aprobado',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado'
        ];

        return $texts[$this->status] ?? 'Desconocido';
    }

    public function getStatusIcon()
    {
        $icons = [
            'pending' => '⏳',
            'approved' => '✅',
            'delivered' => '🎁',
            'cancelled' => '❌'
        ];

        return $icons[$this->status] ?? '❓';
    }
}