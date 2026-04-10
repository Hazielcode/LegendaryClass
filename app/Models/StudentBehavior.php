<?php
// app/Models/StudentBehavior.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentBehavior extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'student_behaviors';

    protected $fillable = [
        'student_id',
        'behavior_id',
        'classroom_id',
        'points_awarded',
        'date',
        'notes',
        'awarded_by',
        'is_approved',
        'is_manual',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'points_awarded' => 'integer',
        'date' => 'datetime',
        'is_approved' => 'boolean'
    ];

    // Relaciones
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function behavior()
    {
        return $this->belongsTo(Behavior::class, 'behavior_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'awarded_by');
    }
}
