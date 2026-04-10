<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Behavior;
use App\Models\Reward;
use App\Models\StudentBehavior;
use App\Models\StudentReward;
use App\Models\StudentPoint;

class LegendaryClassCompleteSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('🎮 Completando datos para LegendaryClass...');
        
        // 1. Asignar personajes a estudiantes
        $this->assignCharactersToStudents();
        
        // 2. Asignar comportamientos y recompensas a todas las aulas
        $this->assignBehaviorsAndRewardsToClassrooms();
        
        // 3. Crear actividad de muestra
        $this->createSampleActivity();
        
        $this->command->info('✅ ¡LegendaryClass completado exitosamente!');
    }

    // Asignar personajes épicos a estudiantes
    private function assignCharactersToStudents()
    {
        $this->command->info('⚔️ Asignando personajes épicos a aventureros...');

        $characters = [
            [
                'character_class' => 'Mago Sabio',
                'character_icon' => '🧙‍♂️',
                'character_type' => 'mage',
                'character_bonus_type' => 'knowledge'
            ],
            [
                'character_class' => 'Guerrero Valiente',
                'character_icon' => '⚔️',
                'character_type' => 'warrior',
                'character_bonus_type' => 'strength'
            ],
            [
                'character_class' => 'Ninja Ágil',
                'character_icon' => '🥷',
                'character_type' => 'ninja',
                'character_bonus_type' => 'agility'
            ],
            [
                'character_class' => 'Arquero Preciso',
                'character_icon' => '🏹',
                'character_type' => 'archer',
                'character_bonus_type' => 'precision'
            ],
            [
                'character_class' => 'Lanzador Creativo',
                'character_icon' => '🪄',
                'character_type' => 'wizard',
                'character_bonus_type' => 'creativity'
            ]
        ];

        $students = User::where('role', 'student')->where('is_active', true)->get();
        
        foreach ($students as $index => $student) {
            $character = $characters[$index % count($characters)];
            
            $student->update([
                'character_class' => $character['character_class'],
                'character_icon' => $character['character_icon'],
                'character_type' => $character['character_type'],
                'character_bonus_type' => $character['character_bonus_type'],
                'experience_points' => rand(200, 1500),
                'level' => rand(2, 6),
                'achievements_count' => rand(1, 8),
                'quests_completed' => rand(3, 15),
                'positive_points' => rand(20, 150),
                'homework_completed' => rand(5, 25),
                'login_streak' => rand(1, 20),
                'first_character_selection' => true
            ]);
        }
        
        $this->command->info("✅ Personajes asignados a {$students->count()} estudiantes");
    }

    // Asignar comportamientos y recompensas a todas las aulas
    private function assignBehaviorsAndRewardsToClassrooms()
    {
        $this->command->info('🏰 Asignando recursos a dominios...');

        $classrooms = Classroom::all();
        $behaviors = Behavior::where('classroom_id', null)->get();
        $rewards = Reward::where('classroom_id', null)->get();

        foreach ($classrooms as $classroom) {
            // Duplicar comportamientos para esta aula
            foreach ($behaviors as $behavior) {
                if (!Behavior::where('classroom_id', $classroom->_id)->where('name', $behavior->name)->exists()) {
                    Behavior::create([
                        'name' => $behavior->name,
                        'description' => $behavior->description,
                        'points' => $behavior->points,
                        'type' => $behavior->type,
                        'category' => $behavior->category,
                        'icon' => $behavior->icon,
                        'color' => $behavior->color,
                        'is_active' => true,
                        'classroom_id' => $classroom->_id,
                        'created_by' => $classroom->teacher_id
                    ]);
                }
            }

            // Duplicar recompensas para esta aula
            foreach ($rewards as $reward) {
                if (!Reward::where('classroom_id', $classroom->_id)->where('name', $reward->name)->exists()) {
                    Reward::create([
                        'name' => $reward->name,
                        'description' => $reward->description,
                        'cost_points' => $reward->cost_points,
                        'type' => $reward->type,
                        'icon' => $reward->icon,
                        'stock_quantity' => $reward->stock_quantity,
                        'is_active' => true,
                        'classroom_id' => $classroom->_id,
                        'created_by' => $classroom->teacher_id,
                        'requirements' => null
                    ]);
                }
            }
        }
        
        $this->command->info("✅ Recursos asignados a {$classrooms->count()} aulas");
    }

    // Crear actividad épica de muestra
    private function createSampleActivity()
    {
        $this->command->info('📊 Creando actividad épica de muestra...');

        $students = User::where('role', 'student')->where('is_active', true)->get();
        $classrooms = Classroom::all();

        foreach ($classrooms as $classroom) {
            $classroomStudents = $students->whereIn('_id', $classroom->student_ids ?? []);
            $behaviors = Behavior::where('classroom_id', $classroom->_id)->get();
            $rewards = Reward::where('classroom_id', $classroom->_id)->get();
            
            if ($behaviors->isEmpty() || $classroomStudents->isEmpty()) continue;

            foreach ($classroomStudents as $student) {
                // Crear 2-5 comportamientos por estudiante en esta aula
                $numBehaviors = rand(2, 5);
                for ($i = 0; $i < $numBehaviors; $i++) {
                    $behavior = $behaviors->random();
                    
                    // Verificar que no existe ya este comportamiento
                    if (!StudentBehavior::where('student_id', $student->_id)
                                       ->where('behavior_id', $behavior->_id)
                                       ->where('classroom_id', $classroom->_id)
                                       ->where('created_at', '>=', now()->subDays(7))
                                       ->exists()) {
                        
                        StudentBehavior::create([
                            'student_id' => $student->_id,
                            'behavior_id' => $behavior->_id,
                            'classroom_id' => $classroom->_id,
                            'awarded_by' => $classroom->teacher_id,
                            'points_awarded' => $behavior->points,
                            'notes' => 'Actividad épica de muestra',
                            'created_at' => now()->subDays(rand(0, 15)),
                            'updated_at' => now()
                        ]);
                    }
                }

                // 30% de probabilidad de canjear una recompensa
                if (rand(1, 10) <= 3 && $rewards->isNotEmpty()) {
                    $reward = $rewards->where('cost_points', '<=', 100)->random();
                    
                    if ($reward && !StudentReward::where('student_id', $student->_id)
                                                ->where('reward_id', $reward->_id)
                                                ->where('classroom_id', $classroom->_id)
                                                ->exists()) {
                        
                        StudentReward::create([
                            'student_id' => $student->_id,
                            'reward_id' => $reward->_id,
                            'classroom_id' => $classroom->_id,
                            'points_spent' => $reward->cost_points,
                            'status' => collect(['pending', 'approved', 'delivered'])->random(),
                            'requested_at' => now()->subDays(rand(0, 10)),
                            'created_at' => now()->subDays(rand(0, 10)),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }
        
        $this->command->info('✅ Actividad épica creada');
    }
}