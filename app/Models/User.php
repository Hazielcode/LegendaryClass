<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'teacher', 'student', 'admin', 'director', 'parent'
        'avatar',
        'parent_email',
        'phone',
        'grade_level',
        'date_of_birth',
        'is_active',
        'preferences',
        'institution_id', // Para directores: ID de la institución
        'strength',
        'intelligence', 
        'agility',
        'creativity',
        'leadership',
        'resilience',
        
        
        // Campos del sistema de personajes
        'character_class',      // Nombre del personaje (Mago, Guerrero, etc.)
        'character_icon',       // Emoji del personaje
        'character_type',       // Tipo interno (mago, guerrero, ninja, arquero, lanzador)
        'character_bonus_type', // Tipo de bonus (knowledge, strength, agility, precision, creativity)
        'experience_points',    // Puntos de experiencia
        'level',               // Nivel actual
        'achievements_count',   // Contador de logros
        'quests_completed',     // Misiones completadas
        'positive_points',      // Puntos positivos recibidos
        'negative_points',      // Puntos negativos recibidos
        'rewards_earned',       // Recompensas ganadas
        'points',              // Puntos disponibles para canjear
        'login_streak',        // Racha de días consecutivos
        'homework_completed',   // Tareas completadas
        'books_read',          // Libros leídos
        'peers_helped',        // Compañeros ayudados
        'creative_projects',    // Proyectos creativos
        'students_mentored',    // Estudiantes mentoreados
        'weekly_positive',      // Puntos positivos esta semana
        'weekly_tasks',         // Tareas esta semana
        'weekly_xp',           // XP ganado esta semana
        'last_login',          // Último login
        'first_character_selection', // Si ya seleccionó personaje
        
        'created_at',
        'updated_at'
    ];

    // Campos ocultos en JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Conversiones de tipos
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
        'preferences' => 'array',
        
        // Casts para sistema de personajes
        'experience_points' => 'integer',
        'level' => 'integer',
        'achievements_count' => 'integer',
        'quests_completed' => 'integer',
        'positive_points' => 'integer',
        'negative_points' => 'integer',
        'rewards_earned' => 'integer',
        'points' => 'integer',
        'login_streak' => 'integer',
        'homework_completed' => 'integer',
        'books_read' => 'integer',
        'peers_helped' => 'integer',
        'creative_projects' => 'integer',
        'students_mentored' => 'integer',
        'weekly_positive' => 'integer',
        'weekly_tasks' => 'integer',
        'weekly_xp' => 'integer',
        'last_login' => 'datetime',
        'first_character_selection' => 'boolean',
        'strength' => 'integer',
        'intelligence' => 'integer',
        'agility' => 'integer', 
        'creativity' => 'integer',
        'leadership' => 'integer',
        'resilience' => 'integer',
    ];

    // Valores por defecto para nuevos usuarios
    protected $attributes = [
        'experience_points' => 0,
        'level' => 1,
        'achievements_count' => 0,
        'quests_completed' => 0,
        'positive_points' => 0,
        'negative_points' => 0,
        'rewards_earned' => 0,
        'points' => 0,
        'login_streak' => 0,
        'homework_completed' => 0,
        'books_read' => 0,
        'peers_helped' => 0,
        'creative_projects' => 0,
        'students_mentored' => 0,
        'weekly_positive' => 0,
        'weekly_tasks' => 0,
        'weekly_xp' => 0,
        'first_character_selection' => false,
        'is_active' => true,
        'strength' => 10,
        'intelligence' => 10,
        'agility' => 10,
        'creativity' => 10,
        'leadership' => 10,
        'resilience' => 10,
    ];

    // ============= RELACIONES EXISTENTES =============
    
    // Relación con aulas
    public function classrooms()
    {
        if ($this->role === 'teacher') {
            return $this->hasMany(Classroom::class, 'teacher_id');
        } else {
            return $this->belongsToMany(Classroom::class, 'classroom_user', 'user_id', 'classroom_id');
        }
    }

    // Relación con puntos de estudiante
    public function studentPoints()
    {
        return $this->hasMany(StudentPoint::class, 'student_id');
    }

    // Relación con comportamientos de estudiante
    public function studentBehaviors()
    {
        return $this->hasMany(StudentBehavior::class, 'student_id');
    }

    // Relación con recompensas de estudiante
    public function studentRewards()
    {
        return $this->hasMany(StudentReward::class, 'student_id');
    }

    // Comportamientos otorgados por este usuario (profesores)
    public function awardedBehaviors()
    {
        return $this->hasMany(StudentBehavior::class, 'awarded_by');
    }

    // Relaciones para sistema de personajes
    public function experienceLogs()
    {
        return $this->hasMany(ExperienceLog::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function quests()
    {
        return $this->hasMany(Quest::class, 'students');
    }

    // Relación para padres - obtener sus hijos
    public function children()
    {
        return $this->belongsToMany(User::class, 'parent_student', 'parent_id', 'student_id');
    }

    public function getChildrenAttribute()
    {
        if ($this->role !== 'parent') {
            return collect();
        }
        return $this->children()->get();
    }

    // Relación para estudiantes - obtener sus padres
    public function parents()
    {
        return $this->belongsToMany(User::class, 'parent_student', 'student_id', 'parent_id');
    }

    public function getParentsAttribute()
    {
        if ($this->role !== 'student') {
            return collect();
        }
        return $this->parents()->get();
    }

    // ============= MÉTODOS DE UTILIDAD PARA ROLES =============
    
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDirector()
    {
        return $this->role === 'director';
    }

    public function isParent()
    {
        return $this->role === 'parent';
    }

    // ============= MÉTODOS DE PERMISOS =============
    
    public function hasAdminAccess()
    {
        return in_array($this->role, ['admin', 'director']);
    }

    public function canViewStudent($studentId)
    {
        if ($this->hasAdminAccess()) return true;
        
        if ($this->role === 'parent') {
            return in_array($studentId, $this->children_ids ?? []);
        }
        
        if ($this->role === 'student') {
            return $this->_id === $studentId || $this->id === $studentId;
        }
        
        if ($this->role === 'teacher') {
            $student = User::find($studentId);
            if (!$student) return false;
            
            $teacherClassrooms = $this->classrooms();
            if ($teacherClassrooms instanceof \Illuminate\Database\Eloquent\Collection) {
                $teacherClassroomIds = $teacherClassrooms->pluck('_id')->toArray();
            } else {
                $teacherClassroomIds = $teacherClassrooms->pluck('_id')->toArray();
            }
            
            $studentClassroomIds = $student->classroom_ids ?? [];
            return !empty(array_intersect($teacherClassroomIds, $studentClassroomIds));
        }
        
        return false;
    }

    // Obtener aulas accesibles según el rol
    public function getAccessibleClassrooms()
    {
        if ($this->hasAdminAccess()) {
            return Classroom::all();
        }
        
        if ($this->role === 'teacher') {
            return Classroom::where('teacher_id', $this->_id)->get();
        }
        
        if ($this->role === 'parent') {
            $childrenClassrooms = collect();
            foreach ($this->children_ids ?? [] as $childId) {
                $child = User::find($childId);
                if ($child) {
                    $classrooms = Classroom::whereIn('_id', $child->classroom_ids ?? [])->get();
                    $childrenClassrooms = $childrenClassrooms->merge($classrooms);
                }
            }
            return $childrenClassrooms->unique('_id');
        }
        
        if ($this->role === 'student') {
            return Classroom::whereIn('_id', $this->classroom_ids ?? [])->get();
        }
        
        return collect();
    }

    // Obtener estudiantes accesibles según el rol
    public function getAccessibleStudents()
    {
        if ($this->hasAdminAccess()) {
            return User::where('role', 'student')->get();
        }
        
        if ($this->role === 'parent') {
            return User::whereIn('_id', $this->children_ids ?? [])->get();
        }
        
        if ($this->role === 'teacher') {
            $classroomIds = Classroom::where('teacher_id', $this->_id)->pluck('_id')->toArray();
            
            $studentIds = Classroom::whereIn('_id', $classroomIds)
                                 ->get()
                                 ->pluck('student_ids')
                                 ->flatten()
                                 ->unique()
                                 ->toArray();
            
            return User::whereIn('_id', $studentIds)->get();
        }
        
        return collect();
    }

    // ============= MÉTODOS PARA SISTEMA DE PERSONAJES =============

    // Obtener XP necesario para el siguiente nivel
    public function getNextLevelXP()
    {
        return ($this->level * $this->level) * 100;
    }

    // Obtener XP del nivel actual
    public function getCurrentLevelXP()
    {
        return $this->level > 1 ? (($this->level - 1) * ($this->level - 1)) * 100 : 0;
    }

    // Obtener progreso hacia el siguiente nivel (porcentaje)
    public function getCurrentLevelProgress()
    {
        $currentLevelXP = $this->getCurrentLevelXP();
        $nextLevelXP = $this->getNextLevelXP();
        $currentXP = $this->experience_points;
        
        if ($nextLevelXP <= $currentLevelXP) return 100;
        
        return min(100, (($currentXP - $currentLevelXP) / ($nextLevelXP - $currentLevelXP)) * 100);
    }

    // Ganar experiencia y verificar subida de nivel
    public function gainExperience($points, $action = 'general', $description = '')
    {
        $oldLevel = $this->level;
        $newXP = $this->experience_points + $points;
        $newLevel = $this->calculateLevel($newXP);

        $this->update([
            'experience_points' => $newXP,
            'level' => $newLevel
        ]);

        // Registrar en log de experiencia si el modelo existe
        if (class_exists('\App\Models\ExperienceLog')) {
            \App\Models\ExperienceLog::create([
                'user_id' => $this->id,
                'points' => $points,
                'action' => $action,
                'description' => $description,
                'source_type' => 'manual'
            ]);
        }

        // Si subió de nivel, dar bonus
        if ($newLevel > $oldLevel) {
            $this->handleLevelUp($oldLevel, $newLevel);
        }

        return [
            'xp_gained' => $points,
            'total_xp' => $newXP,
            'old_level' => $oldLevel,
            'new_level' => $newLevel,
            'level_up' => $newLevel > $oldLevel
        ];
    }

    // Calcular nivel basado en XP
    public function calculateLevel($xp)
    {
        return (int) floor(sqrt($xp / 100)) + 1;
    }

    // Manejar subida de nivel
    private function handleLevelUp($oldLevel, $newLevel)
    {
        // Dar bonus XP por subir de nivel
        $bonusXP = $newLevel * 10;
        $this->increment('experience_points', $bonusXP);

        // Verificar logros de nivel
        $this->checkLevelAchievements($newLevel);
    }

    // Verificar logros por nivel
    private function checkLevelAchievements($level)
    {
        $levelAchievements = [
            5 => ['key' => 'level_5', 'name' => 'Aventurero Novato', 'icon' => '⭐', 'xp' => 50],
            10 => ['key' => 'level_10', 'name' => 'Héroe Veterano', 'icon' => '🌟', 'xp' => 100],
            15 => ['key' => 'level_15', 'name' => 'Maestro Aventurero', 'icon' => '💫', 'xp' => 150],
            20 => ['key' => 'level_20', 'name' => 'Leyenda Viviente', 'icon' => '👑', 'xp' => 200],
            25 => ['key' => 'level_25', 'name' => 'Héroe Legendario', 'icon' => '💎', 'xp' => 300]
        ];

        if (isset($levelAchievements[$level]) && class_exists('\App\Models\Achievement')) {
            $achievement = $levelAchievements[$level];
            
            // Verificar si ya tiene el logro
            if (!\App\Models\Achievement::where('user_id', $this->_id)->where('key', $achievement['key'])->exists()) {
                \App\Models\Achievement::create([
                    'user_id' => $this->_id,
                    'key' => $achievement['key'],
                    'name' => $achievement['name'],
                    'description' => "Alcanzaste el nivel {$level}",
                    'icon' => $achievement['icon'],
                    'xp_reward' => $achievement['xp'],
                    'unlocked_at' => now()
                ]);

                $this->increment('experience_points', $achievement['xp']);
                $this->increment('achievements_count');
            }
        }
    }

    // Obtener información del personaje
    public function getCharacterInfo()
    {
        return [
            'class' => $this->character_class,
            'icon' => $this->character_icon ?? '⚔️',
            'type' => $this->character_type,
            'bonus_type' => $this->character_bonus_type,
            'level' => $this->level,
            'xp' => $this->experience_points,
            'next_level_xp' => $this->getNextLevelXP(),
            'progress' => $this->getCurrentLevelProgress()
        ];
    }

    // Verificar si debe aplicar bonus de personaje
    public function shouldApplyCharacterBonus($actionType)
    {
        $bonusMap = [
            'knowledge' => ['homework', 'quiz', 'reading', 'study'],
            'strength' => ['project', 'challenge', 'persistence', 'effort'],
            'agility' => ['participation', 'quick_response', 'active'],
            'precision' => ['accuracy', 'detail', 'careful', 'perfect'],
            'creativity' => ['creative', 'art', 'innovation', 'original']
        ];

        return isset($bonusMap[$this->character_bonus_type]) && 
               in_array($actionType, $bonusMap[$this->character_bonus_type]);
    }

    // ============= ATRIBUTOS CALCULADOS =============
    
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return Storage::disk('public')->url($this->avatar);
        }
        
        // Si tiene personaje, usar su icono
        if ($this->character_icon) {
            return $this->character_icon;
        }
        
        $defaultAvatars = [
            'director' => '👨‍💼',
            'teacher' => '👨‍🏫',
            'student' => '👩‍🎓',
            'parent' => '👨‍👩‍👧‍👦',
            'admin' => '👤'
        ];
        
        return $defaultAvatars[$this->role] ?? '👤';
    }

    public function getRoleNameAttribute()
    {
        $roleNames = [
            'director' => 'Director',
            'teacher' => 'Maestro',
            'student' => 'Estudiante',
            'parent' => 'Padre',
            'admin' => 'Administrador'
        ];
        
        return $roleNames[$this->role] ?? 'Usuario';
    }

    public function getRoleClassAttribute()
    {
        $roleClasses = [
            'director' => 'bg-purple-100 text-purple-800',
            'teacher' => 'bg-blue-100 text-blue-800',
            'student' => 'bg-green-100 text-green-800',
            'parent' => 'bg-yellow-100 text-yellow-800',
            'admin' => 'bg-gray-100 text-gray-800'
        ];
        
        return $roleClasses[$this->role] ?? 'bg-gray-100 text-gray-800';
    }

    public function canEditUser($targetUserId)
    {
        if ($this->hasAdminAccess()) {
            return true;
        }

        if ($this->_id === $targetUserId || $this->id === $targetUserId) {
            return true;
        }

        if ($this->role === 'parent') {
            return in_array($targetUserId, $this->children_ids ?? []);
        }

        return false;
    }

    public function getTotalPointsAttribute()
    {
        return $this->points ?? 0;
    }

    public function getMaxLevelAttribute()
    {
        return $this->level ?? 1;
    }

    public function getTotalAchievementsAttribute()
    {
        return $this->achievements_count ?? 0;
    }

    // ============= SCOPES PARA CONSULTAS =============
    
    public function scopeTeachers($query)
    {
        return $query->where('role', 'teacher');
    }

    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeParents($query)
    {
        return $query->where('role', 'parent');
    }

    public function scopeDirectors($query)
    {
        return $query->where('role', 'director');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeByRoleAndStatus($query, $role = null, $isActive = null)
    {
        if ($role) {
            $query->where('role', $role);
        }
        
        if ($isActive !== null) {
            $query->where('is_active', $isActive);
        }
        
        return $query;
    }

    // ============= MÉTODOS PARA SISTEMA DE PUNTOS Y RECOMPENSAS =============

    public function getPointsInClassroom($classroomId)
    {
        $studentPoint = $this->studentPoints()
                            ->where('classroom_id', $classroomId)
                            ->first();
        
        return $studentPoint ? $studentPoint->total_points : 0;
    }

    public function hasEnoughPointsFor($reward, $classroomId = null)
    {
        if (is_object($reward)) {
            $cost = $reward->cost_points ?? 0;
        } else {
            $cost = $reward;
        }
        
        if ($classroomId) {
            return $this->getPointsInClassroom($classroomId) >= $cost;
        }
        
        return $this->points >= $cost;
    }

    public function getPendingRewards()
    {
        return $this->studentRewards()
                    ->where('status', 'pending')
                    ->with('reward')
                    ->get();
    }

    public function getActiveRewards()
    {
        return $this->studentRewards()
                    ->where('status', 'approved')
                    ->where(function($query) {
                        $query->where('is_permanent', true)
                              ->orWhere('expires_at', '>', now());
                    })
                    ->with('reward')
                    ->get();
    }

    public function getTotalPointsSpent()
    {
        return $this->studentRewards()
                    ->whereIn('status', ['approved', 'delivered'])
                    ->sum('points_spent');
    }

    public function getRewardCount()
    {
        return $this->studentRewards()
                    ->whereIn('status', ['approved', 'delivered'])
                    ->count();
    }

    public function canAccessReward($reward)
    {
        if (is_object($reward)) {
            $classroomId = $reward->classroom_id ?? null;
        } else {
            return false;
        }
        
        return in_array($classroomId, $this->classroom_ids ?? []);
    }

}