<?php
// app/Models/Behavior.php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Behavior extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'behaviors';

    protected $fillable = [
        'name',
        'description',
        'points',
        'type', // 'positive', 'negative'
        'category', // 'participation', 'homework', 'behavior', 'creativity'
        'icon',
        'color',
        'classroom_id',
        'is_active',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'points' => 'integer',
        'is_active' => 'boolean'
    ];

    // Relaciones
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function studentBehaviors()
    {
        return $this->hasMany(StudentBehavior::class, 'behavior_id');
    }
}