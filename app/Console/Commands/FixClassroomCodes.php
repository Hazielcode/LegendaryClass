<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Classroom;
use Illuminate\Support\Str;

class FixClassroomCodes extends Command
{
    protected $signature = 'classroom:fix-codes';
    protected $description = 'Genera códigos de acceso para aulas que no los tengan';

    public function handle()
    {
        $this->info('🔧 Iniciando reparación de códigos de aula...');
        
        // Buscar aulas sin código o con código null/vacío
        $classroomsWithoutCode = Classroom::where(function($query) {
            $query->whereNull('class_code')
                  ->orWhere('class_code', '')
                  ->orWhere('class_code', 'LOADING');
        })->get();
        
        if ($classroomsWithoutCode->count() === 0) {
            $this->info('✅ Todas las aulas ya tienen códigos de acceso.');
            return;
        }
        
        $this->info("📊 Encontradas {$classroomsWithoutCode->count()} aulas sin código.");
        
        $bar = $this->output->createProgressBar($classroomsWithoutCode->count());
        $bar->start();
        
        foreach ($classroomsWithoutCode as $classroom) {
            $newCode = $this->generateUniqueClassCode();
            $classroom->update(['class_code' => $newCode]);
            
            $this->line("\n🏫 {$classroom->name} → Código: {$newCode}");
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        $this->info('✅ Códigos de aula generados exitosamente!');
    }
    
    private function generateUniqueClassCode()
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (Classroom::where('class_code', $code)->exists());
        
        return $code;
    }
}