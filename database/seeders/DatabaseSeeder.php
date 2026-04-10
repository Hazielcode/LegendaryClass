<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classroom;
use App\Models\StudentPoint;
use App\Models\Behavior;
use App\Models\Reward;
use App\Models\StudentBehavior;
use App\Models\StudentReward;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        echo "\n🚀 Iniciando creación completa del sistema LegendaryClass...\n\n";

        // ============= CREAR USUARIOS ADMINISTRATIVOS =============
        echo "👑 Creando usuarios administrativos...\n";
        
        $director = User::firstOrCreate(
            ['email' => 'director@edugamification.com'],
            [
                'name' => 'Juan Aguirre',
                'password' => Hash::make('director123'),
                'role' => 'director',
                'gender' => 'male',
                'is_active' => true,
                'phone' => '+51 999 888 777',
                'institution_id' => 'inst_001',
                'email_verified_at' => now(),
            ]
        );

        $admin = User::firstOrCreate(
            ['email' => 'admin@edugamification.com'],
            [
                'name' => 'Admin Sistema',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'gender' => 'male',
                'is_active' => true,
                'phone' => '+51 111 000 999',
                'email_verified_at' => now(),
            ]
        );

        // ============= CREAR PROFESORES =============
        echo "🧙‍♂️ Creando profesores...\n";
        
        $teacher = User::firstOrCreate(
            ['email' => 'profesor@demo.com'],
            [
                'name' => 'Luis Galvan',
                'password' => bcrypt('password'),
                'role' => 'teacher',
                'gender' => 'male',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $teacher1 = User::firstOrCreate(
            ['email' => 'profesor1@edugamification.com'],
            [
                'name' => 'Carlos Ramírez',
                'password' => Hash::make('profesor123'),
                'role' => 'teacher',
                'gender' => 'male',
                'is_active' => true,
                'phone' => '+51 888 777 666',
                'grade_level' => '5to Grado',
                'email_verified_at' => now(),
            ]
        );

        $teacher2 = User::firstOrCreate(
            ['email' => 'profesor2@edugamification.com'],
            [
                'name' => 'Ana Flores',
                'password' => Hash::make('profesor123'),
                'role' => 'teacher',
                'gender' => 'female',
                'is_active' => true,
                'phone' => '+51 777 666 555',
                'grade_level' => '3er Grado',
                'email_verified_at' => now(),
            ]
        );

        // ============= CREAR ESTUDIANTES =============
        echo "⚔️ Creando estudiantes aventureros...\n";
        
        $student1 = User::firstOrCreate(
            ['email' => 'samir@demo.com'],
            [
                'name' => 'Samir Alfonso',
                'password' => bcrypt('password'),
                'role' => 'student',
                'gender' => 'male',
                'email_verified_at' => now(),
                'character_class' => 'Mago Sabio',
                'character_icon' => '🧙‍♂️',
                'character_type' => 'mage',
                'level' => 4,
                'points' => 250,
            ]
        );

        $student2 = User::firstOrCreate(
            ['email' => 'juan@demo.com'],
            [
                'name' => 'Juan Carlos López',
                'password' => bcrypt('password'),
                'role' => 'student',
                'gender' => 'male',
                'email_verified_at' => now(),
                'character_class' => 'Guerrero Valiente',
                'character_icon' => '⚔️',
                'character_type' => 'warrior',
                'level' => 2,
                'points' => 180,
            ]
        );

        $student3 = User::firstOrCreate(
            ['email' => 'maria@demo.com'],
            [
                'name' => 'María Isabel Torres',
                'password' => bcrypt('password'),
                'role' => 'student',
                'gender' => 'female',
                'email_verified_at' => now(),
                'character_class' => 'Ninja Ágil',
                'character_icon' => '🥷',
                'character_type' => 'ninja',
                'level' => 3,
                'points' => 320,
            ]
        );

        $student4 = User::firstOrCreate(
            ['email' => 'carlos@demo.com'],
            [
                'name' => 'Carlos Eduardo Ruiz',
                'password' => bcrypt('password'),
                'role' => 'student',
                'gender' => 'male',
                'email_verified_at' => now(),
                'character_class' => 'Arquero Preciso',
                'character_icon' => '🏹',
                'character_type' => 'archer',
                'level' => 6,
                'points' => 95,
            ]
        );

        $pedro = User::firstOrCreate(
            ['email' => 'estudiante1@edugamification.com'],
            [
                'name' => 'Pedro Sánchez',
                'password' => Hash::make('estudiante123'),
                'role' => 'student',
                'gender' => 'male',
                'is_active' => true,
                'phone' => '+51 666 555 444',
                'grade_level' => '5to Grado',
                'date_of_birth' => '2014-03-15',
                'parent_email' => 'padre1@edugamification.com',
                'email_verified_at' => now(),
                'character_class' => 'Lanzador Creativo',
                'character_icon' => '🪄',
                'character_type' => 'wizard',
                'level' => 2,
                'points' => 150,
            ]
        );

        $lucia = User::firstOrCreate(
            ['email' => 'estudiante2@edugamification.com'],
            [
                'name' => 'Lucía Torres',
                'password' => Hash::make('estudiante123'),
                'role' => 'student',
                'gender' => 'female',
                'is_active' => true,
                'phone' => '+51 555 444 333',
                'grade_level' => '5to Grado',
                'date_of_birth' => '2014-07-22',
                'parent_email' => 'padre1@edugamification.com',
                'email_verified_at' => now(),
                'character_class' => 'Mago Sabio',
                'character_icon' => '🧙‍♀️',
                'character_type' => 'mage',
                'level' => 5,
                'points' => 200,
            ]
        );

        $diego = User::firstOrCreate(
            ['email' => 'estudiante3@edugamification.com'],
            [
                'name' => 'Diego Morales',
                'password' => Hash::make('estudiante123'),
                'role' => 'student',
                'gender' => 'male',
                'is_active' => true,
                'phone' => '+51 444 333 222',
                'grade_level' => '3er Grado',
                'date_of_birth' => '2016-01-10',
                'parent_email' => 'padre2@edugamification.com',
                'email_verified_at' => now(),
                'character_class' => 'Guerrero Valiente',
                'character_icon' => '⚔️',
                'character_type' => 'warrior',
                'level' => 2,
                'points' => 75,
            ]
        );

        // ============= CREAR PADRES =============
        echo "🛡️ Creando padres guardianes...\n";
        
        $parent1 = User::firstOrCreate(
            ['email' => 'padre1@edugamification.com'],
            [
                'name' => 'Roberto Sánchez',
                'password' => Hash::make('padre123'),
                'role' => 'parent',
                'gender' => 'male',
                'is_active' => true,
                'phone' => '+51 333 222 111',
                'children_ids' => [$pedro->_id, $lucia->_id],
                'email_verified_at' => now(),
            ]
        );

        $parent2 = User::firstOrCreate(
            ['email' => 'padre2@edugamification.com'],
            [
                'name' => 'Carmen Morales',
                'password' => Hash::make('padre123'),
                'role' => 'parent',
                'gender' => 'female',
                'is_active' => true,
                'phone' => '+51 222 111 000',
                'children_ids' => [$diego->_id],
                'email_verified_at' => now(),
            ]
        );

        // ============= CREAR AULAS MÁGICAS =============
        echo "🏰 Creando aulas mágicas...\n";
        
        $classroom = Classroom::firstOrCreate(
            ['code' => 'DEMO01'],
            [
                'name' => 'Matemáticas 5° A',
                'description' => 'Clase de matemáticas para quinto grado',
                'teacher_id' => $teacher->_id,
                'student_ids' => [$student1->_id, $student2->_id, $student3->_id, $student4->_id],
                'subject' => 'Matemáticas',
                'grade_level' => '5° Primaria',
                'school_year' => '2024-2025',
                'is_active' => true,
                'settings' => [
                    'allow_student_rewards' => true,
                    'public_leaderboard' => true,
                    'parent_notifications' => false
                ]
            ]
        );

        $classroom2 = Classroom::firstOrCreate(
            ['code' => 'DEMO02'],
            [
                'name' => 'Ciencias Naturales 5° A',
                'description' => 'Clase de ciencias naturales para quinto grado',
                'teacher_id' => $teacher->_id,
                'student_ids' => [$student1->_id, $student2->_id, $student3->_id, $pedro->_id, $lucia->_id],
                'subject' => 'Ciencias',
                'grade_level' => '5° Primaria',
                'school_year' => '2024-2025',
                'is_active' => true,
                'settings' => [
                    'allow_student_rewards' => true,
                    'public_leaderboard' => false,
                    'parent_notifications' => true
                ]
            ]
        );

        $classroom3 = Classroom::firstOrCreate(
            ['code' => 'MAT3B'],
            [
                'name' => 'Matemáticas 3° B',
                'description' => 'Clase de matemáticas para tercer grado',
                'teacher_id' => $teacher2->_id,
                'student_ids' => [$diego->_id],
                'subject' => 'Matemáticas',
                'grade_level' => '3° Primaria',
                'school_year' => '2024-2025',
                'is_active' => true,
                'settings' => [
                    'allow_student_rewards' => true,
                    'public_leaderboard' => true,
                    'parent_notifications' => true
                ]
            ]
        );

        // ============= EJECUTAR SEEDERS DE CONTENIDO =============
        echo "⭐ Creando comportamientos y recompensas...\n";
        
        try {
            $this->call([
                BehaviorSeeder::class,
                RewardSeeder::class,
            ]);
        } catch (\Exception $e) {
            echo "⚠️ Error en seeders de contenido: " . $e->getMessage() . "\n";
        }

        // ============= CREAR PUNTOS PARA ESTUDIANTES =============
        echo "🎯 Asignando puntos a estudiantes...\n";
        
        $studentsData = [
            [$student1->_id, $classroom->_id, 250, 4],
            [$student1->_id, $classroom2->_id, 220, 4],
            [$student2->_id, $classroom->_id, 180, 2],
            [$student2->_id, $classroom2->_id, 190, 2],
            [$student3->_id, $classroom->_id, 320, 3],
            [$student3->_id, $classroom2->_id, 300, 3],
            [$student4->_id, $classroom->_id, 95, 6],
            [$pedro->_id, $classroom2->_id, 150, 2],
            [$lucia->_id, $classroom2->_id, 200, 5],
            [$diego->_id, $classroom3->_id, 75, 2],
        ];

        foreach ($studentsData as $data) {
            StudentPoint::firstOrCreate(
                [
                    'student_id' => $data[0],
                    'classroom_id' => $data[1]
                ],
                [
                    'total_points' => $data[2],
                    'level' => $data[3],
                    'experience_points' => $data[2],
                    'points_spent' => 0,
                    'streak_days' => rand(1, 15),
                    'achievements' => $data[2] >= 100 ? ['first_hundred'] : [],
                    'last_activity' => now()->subDays(rand(0, 3))
                ]
            );
        }

        // ============= CREAR ACTIVIDAD DE MUESTRA =============
        echo "📊 Creando actividad de muestra...\n";
        
        try {
            $this->call([
                LegendaryClassCompleteSeeder::class,
            ]);
        } catch (\Exception $e) {
            echo "⚠️ Error al crear actividad: " . $e->getMessage() . "\n";
        }

        // ============= MOSTRAR RESUMEN FINAL =============
        echo "\n🎉 ¡SISTEMA LEGENDARYCLASS COMPLETADO!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📧 CREDENCIALES DE ACCESO:\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "👑 DIRECTOR: director@edugamification.com | director123\n";
        echo "🧙‍♂️ PROFESOR: profesor@demo.com | password\n";
        echo "⚔️ ESTUDIANTE: samir@demo.com | password\n";
        echo "🛡️ PADRE: padre1@edugamification.com | padre123\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📊 ESTADÍSTICAS:\n";
        echo "   👥 Usuarios: " . User::count() . "\n";
        echo "   🏰 Aulas: " . Classroom::count() . "\n";
        echo "   ⭐ Comportamientos: " . Behavior::count() . "\n";
        echo "   🎁 Recompensas: " . Reward::count() . "\n";
        echo "   📈 Actividades: " . StudentBehavior::count() . "\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }
}