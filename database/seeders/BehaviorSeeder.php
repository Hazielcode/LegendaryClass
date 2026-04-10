<?php

namespace Database\Seeders;

use App\Models\Behavior;
use Illuminate\Database\Seeder;

class BehaviorSeeder extends Seeder
{
    public function run()
    {
        $behaviors = [
            // Comportamientos Positivos
            [
                'name' => 'Excelente participación',
                'description' => 'Participa activamente en clase con comentarios relevantes',
                'points' => 10,
                'type' => 'positive',
                'category' => 'participation',
                'icon' => '🙋',
                'color' => '#10B981'
            ],
            [
                'name' => 'Tarea completada a tiempo',
                'description' => 'Entrega la tarea completa y a tiempo',
                'points' => 5,
                'type' => 'positive',
                'category' => 'homework',
                'icon' => '📝',
                'color' => '#059669'
            ],
            [
                'name' => 'Ayuda a compañeros',
                'description' => 'Ayuda a otros estudiantes con sus dudas',
                'points' => 8,
                'type' => 'positive',
                'category' => 'behavior',
                'icon' => '🤝',
                'color' => '#0891B2'
            ],
            [
                'name' => 'Trabajo creativo excepcional',
                'description' => 'Demuestra creatividad e innovación en sus trabajos',
                'points' => 12,
                'type' => 'positive',
                'category' => 'creativity',
                'icon' => '🎨',
                'color' => '#7C3AED'
            ],
            [
                'name' => 'Llega puntual',
                'description' => 'Llega a tiempo a clase',
                'points' => 3,
                'type' => 'positive',
                'category' => 'punctuality',
                'icon' => '⏰',
                'color' => '#0D9488'
            ],
            [
                'name' => 'Demuestra respeto',
                'description' => 'Muestra respeto hacia compañeros y profesores',
                'points' => 6,
                'type' => 'positive',
                'category' => 'respect',
                'icon' => '🤲',
                'color' => '#7C2D12'
            ],
            [
                'name' => 'Gran esfuerzo',
                'description' => 'Demuestra esfuerzo excepcional en las actividades',
                'points' => 7,
                'type' => 'positive',
                'category' => 'effort',
                'icon' => '💪',
                'color' => '#DC2626'
            ],
            [
                'name' => 'Excelente trabajo en equipo',
                'description' => 'Colabora efectivamente en actividades grupales',
                'points' => 9,
                'type' => 'positive',
                'category' => 'teamwork',
                'icon' => '👥',
                'color' => '#2563EB'
            ],

            // Comportamientos Negativos
            [
                'name' => 'Tarea no entregada',
                'description' => 'No entrega la tarea asignada',
                'points' => -5,
                'type' => 'negative',
                'category' => 'homework',
                'icon' => '📝',
                'color' => '#EF4444'
            ],
            [
                'name' => 'Interrumpe la clase',
                'description' => 'Interrumpe o distrae durante la clase',
                'points' => -3,
                'type' => 'negative',
                'category' => 'behavior',
                'icon' => '🔇',
                'color' => '#DC2626'
            ],
            [
                'name' => 'Llega tarde',
                'description' => 'Llega tarde a clase sin justificación',
                'points' => -2,
                'type' => 'negative',
                'category' => 'punctuality',
                'icon' => '⏰',
                'color' => '#B91C1C'
            ],
            [
                'name' => 'Falta de respeto',
                'description' => 'Muestra falta de respeto hacia otros',
                'points' => -8,
                'type' => 'negative',
                'category' => 'respect',
                'icon' => '😠',
                'color' => '#991B1B'
            ],
            [
                'name' => 'No participa',
                'description' => 'No participa en actividades de clase',
                'points' => -4,
                'type' => 'negative',
                'category' => 'participation',
                'icon' => '😴',
                'color' => '#7F1D1D'
            ]
        ];

        foreach ($behaviors as $behavior) {
            Behavior::create(array_merge($behavior, [
                'is_active' => true,
                'created_by' => null, // Sistema
                'classroom_id' => null // Se asignará cuando se creen aulas
            ]));
        }
    }
}