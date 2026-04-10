<?php
// app/Models/StudentPoint.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPoint extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'student_points';

    protected $fillable = [
        'student_id',
        'classroom_id',
        'total_points',
        'level',
        'experience_points',
        'points_spent',
        'streak_days',
        'last_activity',
        'achievements',
        'updated_at'
    ];

    protected $casts = [
        'total_points' => 'integer',
        'level' => 'integer',
        'experience_points' => 'integer',
        'points_spent' => 'integer',
        'streak_days' => 'integer',
        'last_activity' => 'datetime',
        'achievements' => 'array'
    ];

    // Relaciones
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
