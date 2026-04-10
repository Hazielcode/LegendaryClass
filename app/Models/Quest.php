<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Quest extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'quests';

    protected $fillable = [
        'title',
        'description',
        'xp_reward',
        'type',
        'status',
        'students',
        'completed_by',
        'classroom_id',
        'teacher_id',
        'due_date',
        'requirements',
        'completion_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'xp_reward' => 'integer',
        'students' => 'array',
        'completed_by' => 'array',
        'requirements' => 'array',
        'due_date' => 'datetime',
        'completion_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $attributes = [
        'status' => 'active',
        'xp_reward' => 50,
        'students' => [],
        'completed_by' => []
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function isCompletedBy($userId)
    {
        return in_array($userId, $this->completed_by ?? []);
    }

    public function getCompletionPercentage()
    {
        $totalStudents = count($this->students ?? []);
        $completedStudents = count($this->completed_by ?? []);
        
        return $totalStudents > 0 ? ($completedStudents / $totalStudents) * 100 : 0;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForStudent($query, $userId)
    {
        return $query->where('students', $userId);
    }

    public function scopeNotCompletedBy($query, $userId)
    {
        return $query->where('completed_by', 'not', $userId);
    }
}