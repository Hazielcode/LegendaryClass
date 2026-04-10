<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Teacher\ClassroomController;
use App\Http\Controllers\Teacher\BehaviorController;
use App\Http\Controllers\Teacher\StudentBehaviorController;
use App\Http\Controllers\Teacher\RewardController;
use App\Http\Controllers\Director\DirectorController;
use App\Http\Controllers\Parent\ParentController;
use App\Http\Controllers\Student\StudentsController;
use App\Http\Controllers\Student\CharacterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Ruta principal con redirección por rol
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        switch ($user->role) {
            case 'director':
                return redirect('/director/dashboard');
            case 'teacher':
                return redirect('/teacher/dashboard');
            case 'student':
                return redirect('/students/dashboard');
            case 'parent':
                return redirect('/parent/dashboard');
            case 'admin':
                return redirect('/director/dashboard');
            default:
                return redirect('/login');
        }
    }
    return view('welcome');
});

// Dashboard principal con redirección por rol
Route::get('/dashboard', function () {
    if (auth()->check()) {
        $user = auth()->user();
        switch ($user->role) {
            case 'director':
                return redirect('/director/dashboard');
            case 'teacher':
                return redirect('/teacher/dashboard');
            case 'student':
                // Verificar si ya seleccionó personaje
                if (!$user->first_character_selection) {
                    return redirect()->route('students.character.select');
                }
                return redirect('/students/dashboard'); 
            case 'parent':
                return redirect('/parent/dashboard');
            case 'admin':
                return redirect('/director/dashboard');
            default:
                return redirect('/login');
        }
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas del Director
Route::middleware(['auth', 'role:director'])->prefix('director')->name('director.')->group(function () {
    Route::get('/dashboard', [DirectorController::class, 'dashboard'])->name('dashboard');
    Route::get('/teachers', [DirectorController::class, 'teachers'])->name('teachers');
    Route::get('/students', [DirectorController::class, 'students'])->name('students');
    Route::get('/classrooms', [DirectorController::class, 'classrooms'])->name('classrooms');
    Route::get('/reports', [DirectorController::class, 'reports'])->name('reports');
    Route::get('/user-management', [DirectorController::class, 'userManagement'])->name('user-management');
    Route::patch('/users/{user}/role', [DirectorController::class, 'updateUserRole'])->name('users.update-role');
    Route::patch('/users/{user}/toggle-status', [DirectorController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::post('/create-user', [DirectorController::class, 'createUser'])->name('createUser');
    Route::get('/get-stats', [DirectorController::class, 'getStats'])->name('get-stats');
});

// Rutas de Padres
Route::middleware(['auth', 'role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentController::class, 'dashboard'])->name('dashboard');
    Route::get('/child/{child}/progress', [ParentController::class, 'childProgress'])->name('child.progress');
    Route::get('/classroom/{classroom}', [ParentController::class, 'classroomView'])->name('classroom.view');
    Route::post('/link-child', [ParentController::class, 'linkChild'])->name('link-child');
    Route::delete('/unlink-child/{child}', [ParentController::class, 'unlinkChild'])->name('unlink-child');
    Route::patch('/child/{child}', [ParentController::class, 'updateChild'])->name('child.update');
});

// Rutas de Estudiantes
Route::middleware(['auth', 'role:student'])->prefix('students')->name('students.')->group(function () {
    // Ruta de selección de personaje (sin middleware de verificación)
    Route::get('/character/select', [StudentsController::class, 'characterSelect'])->name('character.select');
    Route::post('/character/select', [StudentsController::class, 'selectCharacter'])->name('character.store');
    
    // Todas las demás rutas requieren selección de personaje
    
        Route::get('/dashboard', [StudentsController::class, 'dashboard'])->name('dashboard');
        Route::post('/select-character', [StudentsController::class, 'selectCharacter'])->name('select-character');
        Route::get('/progress', [StudentsController::class, 'getProgress'])->name('progress');
        Route::get('/character-info', [StudentsController::class, 'getCharacterInfo'])->name('character-info');
        Route::get('/classrooms', action: [StudentsController::class, 'classrooms'])->name('classrooms.index');
        Route::get('/classrooms/{id}', [StudentsController::class, 'showClassroom'])->name('classrooms.show');
        Route::get('/join-classroom', [StudentsController::class, 'joinClassroom'])->name('join-classroom');
        Route::post('/join-classroom', [StudentsController::class, 'processJoin'])->name('process-join');
        Route::delete('/leave-classroom/{classroom}', [StudentsController::class, 'leaveClassroom'])->name('leave-classroom');
        Route::post('/quests/{id}/complete', [StudentsController::class, 'completeQuest'])->name('quests.complete');
        Route::get('/quests', [StudentsController::class, 'myQuests'])->name('quests.index');
        Route::post('/rewards/{id}/buy', [StudentsController::class, 'buyReward'])->name('rewards.buy');
        Route::get('/my-rewards', [StudentsController::class, 'myRewards'])->name('my-rewards');
        Route::get('/achievements', [StudentsController::class, 'myAchievements'])->name('achievements');
        Route::get('/profile', [StudentsController::class, 'profile'])->name('profile');
        Route::get('/character/profile', [CharacterController::class, 'profile'])->name('character.profile');
        Route::get('/character/data', [CharacterController::class, 'getCharacterData'])->name('character.data');
        Route::post('/upgrade-stat', [StudentsController::class, 'upgradeStat'])->name('upgrade-stat');
        Route::get('/store', [StudentsController::class, 'store'])->name('store');
        Route::get('/store/category/{category}', [StudentsController::class, 'getRewardsByCategory'])->name('store.category');
        Route::get('/rewards/history', [StudentsController::class, 'rewardsHistory'])->name('rewards.history');
    });



// Rutas de Teacher (Profesores)
Route::middleware(['auth', 'role:teacher,admin,profesor'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', function() { return view('teacher.dashboard'); })->name('dashboard');
    
    // Rutas de comportamientos
    Route::resource('behaviors', BehaviorController::class);
    
    // Rutas de aulas con slug 
    Route::resource('classrooms', controller: ClassroomController::class)->parameters([
        'classrooms' => 'classroom:slug'
    ]);

    Route::delete('/classrooms/{classroom:slug}/remove-student', [ClassroomController::class, 'removeStudent'])->name('classrooms.remove-student');

    
    // Rutas adicionales para reportes  
    Route::get('/classrooms/{classroom:slug}/reports', [ClassroomController::class, 'reports'])->name('classrooms.reports');
    Route::get('/classrooms/{classroom:slug}/export-reports', [ClassroomController::class, 'exportReports'])->name('classrooms.export-reports');
    
    Route::post('/classrooms/{classroom:slug}/regenerate-code', [ClassroomController::class, 'regenerateCode'])->name('classrooms.regenerate-code');    
    // Rutas de comportamientos de estudiantes
    Route::post('/student-behaviors', [StudentBehaviorController::class, 'store'])->name('student-behaviors.store');
    Route::get('/student-behaviors', [StudentBehaviorController::class, 'index'])->name('student-behaviors.index');
    Route::delete('/student-behaviors/{studentBehavior}', [StudentBehaviorController::class, 'destroy'])->name('student-behaviors.destroy');
    Route::delete('/classrooms/{classroom:slug}/remove-all-students', [ClassroomController::class, 'removeAllStudents'])->name('classrooms.remove-all-students');

    // Rutas de recompensas
    Route::resource('rewards', RewardController::class);
    Route::patch('/student-rewards/{studentReward}/update-status', [RewardController::class, 'updateRewardStatus'])->name('student-rewards.update-status');
    Route::patch('/rewards/{reward}/toggle-status', [RewardController::class, 'toggleStatus'])->name('rewards.toggle-status');
    Route::post('/rewards/{reward}/approve-all-pending', [RewardController::class, 'approveAllPending'])->name('rewards.approve-all-pending');
    
    // Rutas para importación de estudiantes
    Route::get('/classrooms/{classroom:slug}/import-students', [ClassroomController::class, 'importStudentsForm'])->name('classrooms.import-students-form');
    Route::post('/classrooms/{classroom:slug}/import-students', [ClassroomController::class, 'importStudents'])->name('classrooms.import-students');
    Route::get('/download-students-template', [ClassroomController::class, 'downloadStudentsTemplate'])->name('classrooms.download-template');
    Route::post('/classrooms/{classroom:slug}/adjust-points', [ClassroomController::class, 'adjustStudentPoints'])->name('classrooms.adjust-points');
    });

// Rutas autenticadas generales
Route::middleware('auth')->group(function () {
    
    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', function() {
        return redirect()->route('profile.edit.user', auth()->id());
    });
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit.user');
    Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update.user');
    Route::patch('/profile/{user}/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show.user');
    Route::patch('/profile', function() {
        return redirect()->route('profile.update.user', auth()->id());
    })->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas legacy para retrocompatibilidad (usando Teacher controllers)
    Route::post('/join-classroom', [ClassroomController::class, 'joinByCode'])->name('classrooms.join');
    Route::get('/join', function() { return view('classrooms.join'); })->name('classrooms.join.form');
    
    // Rutas legacy de comportamientos para retrocompatibilidad
    Route::middleware('role:teacher,admin')->group(function () {
        Route::get('/behaviors', function() { 
            return redirect()->route('teacher.behaviors.index'); 
        });
        Route::get('/behaviors/create', function() { 
            return redirect()->route('teacher.behaviors.create'); 
        });
    });
    
    // Rutas legacy de recompensas (para estudiantes)
    Route::post('/redeem-reward', [RewardController::class, 'redeem'])
         ->middleware('role:student')
         ->name('rewards.redeem');
});

// Incluir rutas de autenticación
require __DIR__.'/auth.php';