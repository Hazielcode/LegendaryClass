<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Classroom;

class SetupGamificationCommand extends Command
{
    protected $signature = 'gamification:setup 
                            {--fresh : Fresh install with sample data}
                            {--demo : Install with demo users and classrooms}';

    protected $description = 'Setup the gamification system with initial data';

    public function handle()
    {
        $this->info('🎮 Configurando Sistema de Gamificación Educativa...');
        $this->newLine();

        if ($this->option('fresh')) {
            $this->handleFreshInstall();
        } elseif ($this->option('demo')) {
            $this->handleDemoInstall();
        } else {
            $this->handleInteractiveSetup();
        }

        $this->info('✅ ¡Configuración completada exitosamente!');
    }

    private function handleFreshInstall()
    {
        $this->warn('⚠️  Esto eliminará todos los datos existentes.');
        
        if ($this->confirm('¿Continuar con la instalación fresh?')) {
            $this->call('migrate:fresh');
            $this->call('db:seed', ['--class' => 'BehaviorSeeder']);
            $this->call('db:seed', ['--class' => 'RewardSeeder']);
            $this->info('🗄️ Base de datos reiniciada con datos básicos.');
        }
    }

    private function handleDemoInstall()
    {
        $this->info('📊 Instalando datos de demostración...');
        
        if ($this->confirm('¿Instalar con usuarios y aulas de demo?')) {
            $this->call('migrate:fresh', ['--seed' => true]);
            $this->displayDemoCredentials();
        }
    }

    private function handleInteractiveSetup()
    {
        $this->info('🛠️ Configuración Interactiva');
        
        $action = $this->choice('¿Qué deseas hacer?', [
            'fresh' => 'Instalación limpia (elimina datos)',
            'demo' => 'Instalar datos de demostración',
            'teacher' => 'Crear nuevo profesor',
            'classroom' => 'Crear nueva aula',
            'status' => 'Ver estado del sistema'
        ]);

        switch ($action) {
            case 'fresh':
                $this->handleFreshInstall();
                break;
            case 'demo':
                $this->handleDemoInstall();
                break;
            case 'teacher':
                $this->createTeacher();
                break;
            case 'classroom':
                $this->createClassroom();
                break;
            case 'status':
                $this->showSystemStatus();
                break;
        }
    }

    private function createTeacher()
    {
        $this->info('👨‍🏫 Creando nuevo profesor...');
        
        $name = $this->ask('Nombre del profesor');
        $email = $this->ask('Email del profesor');
        $password = $this->secret('Contraseña');

        if (User::where('email', $email)->exists()) {
            $this->error('❌ Ya existe un usuario con ese email.');
            return;
        }

        $teacher = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => 'teacher',
            'email_verified_at' => now(),
            'is_active' => true
        ]);

        $this->info("✅ Profesor creado: {$teacher->name} ({$teacher->email})");
    }

    private function createClassroom()
    {
        $teachers = User::where('role', 'teacher')->get();
        
        if ($teachers->isEmpty()) {
            $this->error('❌ No hay profesores registrados. Crea un profesor primero.');
            return;
        }

        $this->info('🏫 Creando nueva aula...');
        
        $teacherOptions = $teachers->pluck('name', 'id')->toArray();
        $teacherId = $this->choice('Selecciona el profesor', $teacherOptions);
        
        $name = $this->ask('Nombre del aula');
        $subject = $this->choice('Materia', [
            'Matemáticas', 'Ciencias', 'Lengua', 'Historia', 
            'Geografía', 'Arte', 'Educación Física', 'Inglés', 'Otro'
        ]);
        $gradeLevel = $this->ask('Grado/Nivel');

        $classroom = Classroom::create([
            'name' => $name,
            'teacher_id' => $teacherId,
            'subject' => $subject,
            'grade_level' => $gradeLevel,
            'class_code' => strtoupper(\Str::random(6)),
            'school_year' => date('Y') . '-' . (date('Y') + 1),
            'student_ids' => [],
            'is_active' => true,
            'settings' => [
                'allow_student_rewards' => true,
                'public_leaderboard' => false,
                'parent_notifications' => true
            ]
        ]);

        $this->info("✅ Aula creada: {$classroom->name}");
        $this->info("🔑 Código de acceso: {$classroom->class_code}");
    }

    private function showSystemStatus()
    {
        $this->info('📊 Estado del Sistema');
        $this->newLine();

        $teachers = User::where('role', 'teacher')->count();
        $students = User::where('role', 'student')->count();
        $classrooms = Classroom::count();
        $behaviors = \App\Models\Behavior::count();
        $rewards = \App\Models\Reward::count();

        $this->table(['Elemento', 'Cantidad'], [
            ['👨‍🏫 Profesores', $teachers],
            ['👩‍🎓 Estudiantes', $students],
            ['🏫 Aulas', $classrooms],
            ['⭐ Comportamientos', $behaviors],
            ['🎁 Recompensas', $rewards],
        ]);

        if ($classrooms > 0) {
            $this->newLine();
            $this->info('🏫 Aulas registradas:');
            Classroom::with('teacher')->get()->each(function($classroom) {
                $studentCount = count($classroom->student_ids ?? []);
                $this->line("  • {$classroom->name} ({$classroom->subject}) - {$classroom->teacher->name} - {$studentCount} estudiantes - Código: {$classroom->class_code}");
            });
        }
    }

    private function displayDemoCredentials()
    {
        $this->newLine();
        $this->info('🎉 ¡Datos de demostración instalados!');
        $this->newLine();
        
        $this->table(['Tipo', 'Email', 'Contraseña'], [
            ['👨‍🏫 Profesor', 'profesor@demo.com', 'password'],
            ['👩‍🎓 Estudiante', 'ana@demo.com', 'password'],
            ['👨‍🎓 Estudiante', 'juan@demo.com', 'password'],
            ['👩‍🎓 Estudiante', 'maria@demo.com', 'password'],
            ['👨‍🎓 Estudiante', 'carlos@demo.com', 'password'],
        ]);

        $this->newLine();
        $this->info('🏫 Aulas de demostración:');
        $this->line('  📐 Matemáticas 5° A (Código: DEMO01)');
        $this->line('  🔬 Ciencias Naturales 5° A (Código: DEMO02)');
    }
}