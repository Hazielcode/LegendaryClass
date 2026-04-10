<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Classroom extends Model
{
    
    protected $fillable = [
        'name',
        'description',
        'teacher_id',
        'subject',
        'grade_level',
        'school_year',
        'class_code',
        'avatar',
        'is_active',
        'settings',
        'slug',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Generate a slug for the classroom
     */
    public function generateSlug()
    {
        $baseSlug = \Illuminate\Support\Str::slug($this->name . '-' . $this->subject . '-' . $this->grade_level);
        $slug = $baseSlug;
        $counter = 1;
        
        // Asegurar que el slug sea único
        while (self::where('slug', $slug)->where('_id', '!=', $this->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Generar código único de aula
     */
    public function generateUniqueClassCode()
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (self::where('class_code', $code)->exists());
        
        return $code;
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($classroom) {
            if (empty($classroom->slug)) {
                $classroom->slug = $classroom->generateSlug();
            }
            
            // Generar código de acceso automáticamente si no existe
            if (empty($classroom->class_code)) {
                $classroom->class_code = $classroom->generateUniqueClassCode();
            }
        });
        
        static::updating(function ($classroom) {
            if ($classroom->isDirty(['name', 'subject', 'grade_level']) || empty($classroom->slug)) {
                $classroom->slug = $classroom->generateSlug();
            }
        });
    }

    // Relaciones
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'classroom_user', 'classroom_id', 'user_id');
    }

    public function behaviors()
    {
        return $this->hasMany(Behavior::class, 'classroom_id');
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class, 'classroom_id');
    }
}