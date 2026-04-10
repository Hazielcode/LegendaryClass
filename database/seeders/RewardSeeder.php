<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    public function run()
    {
        $rewards = [
            // Privilegios
            [
                'name' => 'Ser ayudante del profesor',
                'description' => 'Ayudar al profesor durante una clase completa',
                'cost_points' => 50,
                'type' => 'privilege',
                'icon' => '👑',
                'stock_quantity' => null
            ],
            [
                'name' => 'Elegir la actividad del día',
                'description' => 'Elegir una actividad educativa para toda la clase',
                'cost_points' => 75,
                'type' => 'privilege',
                'icon' => '🎯',
                'stock_quantity' => null
            ],
            [
                'name' => 'Sentarse donde quiera',
                'description' => 'Elegir su lugar en el aula por una semana',
                'cost_points' => 30,
                'type' => 'privilege',
                'icon' => '🪑',
                'stock_quantity' => null
            ],
            [
                'name' => '10 minutos extra de recreo',
                'description' => 'Disfrutar de 10 minutos adicionales de recreo',
                'cost_points' => 40,
                'type' => 'privilege',
                'icon' => '⏰',
                'stock_quantity' => null
            ],

            // Objetos/Items
            [
                'name' => 'Set de stickers especiales',
                'description' => 'Colección de stickers temáticos educativos',
                'cost_points' => 25,
                'type' => 'item',
                'icon' => '⭐',
                'stock_quantity' => 20
            ],
            [
                'name' => 'Lápiz personalizado',
                'description' => 'Lápiz con su nombre grabado',
                'cost_points' => 35,
                'type' => 'item',
                'icon' => '✏️',
                'stock_quantity' => 15
            ],
            [
                'name' => 'Cuaderno especial',
                'description' => 'Cuaderno con diseño único del aula',
                'cost_points' => 60,
                'type' => 'item',
                'icon' => '📓',
                'stock_quantity' => 10
            ],
            [
                'name' => 'Marcadores de colores',
                'description' => 'Set de marcadores para proyectos creativos',
                'cost_points' => 45,
                'type' => 'item',
                'icon' => '🖍️',
                'stock_quantity' => 12
            ],

            // Actividades
            [
                'name' => 'Juego educativo en línea',
                'description' => '30 minutos de juego educativo en computadora',
                'cost_points' => 80,
                'type' => 'activity',
                'icon' => '🎮',
                'stock_quantity' => null
            ],
            [
                'name' => 'Tiempo libre dirigido',
                'description' => '15 minutos para hacer actividad favorita',
                'cost_points' => 55,
                'type' => 'activity',
                'icon' => '🎨',
                'stock_quantity' => null
            ],
            [
                'name' => 'Liderar presentación',
                'description' => 'Liderar una mini-presentación sobre tema favorito',
                'cost_points' => 70,
                'type' => 'activity',
                'icon' => '🎤',
                'stock_quantity' => null
            ],

            // Reconocimientos
            [
                'name' => 'Certificado de excelencia',
                'description' => 'Certificado personalizado de reconocimiento',
                'cost_points' => 100,
                'type' => 'recognition',
                'icon' => '🏆',
                'stock_quantity' => null
            ],
            [
                'name' => 'Estudiante del mes',
                'description' => 'Reconocimiento como estudiante destacado del mes',
                'cost_points' => 200,
                'type' => 'recognition',
                'icon' => '🌟',
                'stock_quantity' => 1
            ],
            [
                'name' => 'Mención en cartelera',
                'description' => 'Su foto y logros destacados en la cartelera del aula',
                'cost_points' => 85,
                'type' => 'recognition',
                'icon' => '📋',
                'stock_quantity' => null
            ],
            [
                'name' => 'Diploma de comportamiento',
                'description' => 'Diploma especial por excelente comportamiento',
                'cost_points' => 120,
                'type' => 'recognition',
                'icon' => '📜',
                'stock_quantity' => null
            ]
        ];

        foreach ($rewards as $reward) {
            Reward::create(array_merge($reward, [
                'is_active' => true,
                'created_by' => null, // Sistema
                'classroom_id' => null, // Se asignará cuando se creen aulas
                'requirements' => null
            ]));
        }
    }
}