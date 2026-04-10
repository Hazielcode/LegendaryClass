<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ExperienceLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'experience_logs';

    protected $fillable = [
        'user_id',
        'points',
        'action',
        'description',
        'source_type',
        'source_id',
        'classroom_id',
        'multiplier',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'points' => 'integer',
        'multiplier' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $attributes = [
        'multiplier' => 1.0
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}