<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Classroom;

class UpdateClassroomSlugs extends Command
{
    protected $signature = 'classrooms:update-slugs';
    protected $description = 'Update slugs for existing classrooms';

    public function handle()
    {
        $this->info('Actualizando slugs para aulas existentes...');
        
        $classrooms = Classroom::whereNull('slug')->orWhere('slug', '')->get();
        
        if ($classrooms->isEmpty()) {
            $this->info('No hay aulas sin slug para actualizar.');
            return;
        }

        $count = 0;
        foreach ($classrooms as $classroom) {
            $slug = $classroom->generateSlug();
            $classroom->update(['slug' => $slug]);
            $count++;
            
            $this->line("Aula '{$classroom->name}' actualizada con slug: {$slug}");
        }

        $this->info("✅ Se actualizaron {$count} aulas exitosamente.");
    }
}