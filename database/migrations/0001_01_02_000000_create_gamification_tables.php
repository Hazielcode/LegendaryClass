<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Aulas
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->string('grade_level')->nullable();
            $table->string('school_year')->nullable();
            $table->string('class_code')->unique();
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Relación Aula-Estudiante
        Schema::create('classroom_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Relación Padre-Hijo
        Schema::create('parent_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Comportamientos (Reglas de aula)
        Schema::create('behaviors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('points');
            $table->enum('type', ['positive', 'negative']);
            $table->string('icon')->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('classroom_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Historial de Comportamientos otorgados
        Schema::create('student_behaviors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('behavior_id')->constrained()->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
            $table->foreignId('awarded_by')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Recompensas disponibles
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('cost_points');
            $table->string('icon')->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('classroom_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('stock')->nullable(); // null = inf
            $table->boolean('is_permanent')->default(false);
            $table->timestamps();
        });

        // Recompensas obtenidas por estudiantes
        Schema::create('student_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reward_id')->constrained()->onDelete('cascade');
            $table->foreignId('classroom_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected', 'delivered'])->default('pending');
            $table->integer('points_spent');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // Puntos totales por aula
        Schema::create('student_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
            $table->integer('total_points')->default(0);
            $table->timestamps();
            $table->unique(['student_id', 'classroom_id']);
        });

        // Misiones / Quests
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('xp_reward');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('classroom_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamp('due_date')->nullable();
            $table->timestamps();
        });

        // Misiones de estudiante
        Schema::create('quest_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quest_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['assigned', 'in_progress', 'completed'])->default('assigned');
            $table->timestamps();
        });

        // Logros (Achievements)
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('key');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('xp_reward')->default(0);
            $table->timestamp('unlocked_at');
            $table->timestamps();
            $table->unique(['user_id', 'key']);
        });

        // Historial XP
        Schema::create('experience_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('points');
            $table->string('action');
            $table->text('description')->nullable();
            $table->string('source_type')->default('system');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_logs');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('quest_student');
        Schema::dropIfExists('quests');
        Schema::dropIfExists('student_points');
        Schema::dropIfExists('student_rewards');
        Schema::dropIfExists('rewards');
        Schema::dropIfExists('student_behaviors');
        Schema::dropIfExists('behaviors');
        Schema::dropIfExists('parent_student');
        Schema::dropIfExists('classroom_user');
        Schema::dropIfExists('classrooms');
    }
};
