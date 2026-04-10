<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('student');
            $table->string('avatar')->nullable();
            $table->string('parent_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('grade_level')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('preferences')->nullable();
            $table->string('institution_id')->nullable();
            
            // Stats
            $table->integer('strength')->default(10);
            $table->integer('intelligence')->default(10);
            $table->integer('agility')->default(10);
            $table->integer('creativity')->default(10);
            $table->integer('leadership')->default(10);
            $table->integer('resilience')->default(10);
            
            // System Characters
            $table->string('character_class')->nullable();
            $table->string('character_icon')->nullable();
            $table->string('character_type')->nullable();
            $table->string('character_bonus_type')->nullable();
            $table->integer('experience_points')->default(0);
            $table->integer('level')->default(1);
            
            // Progress
            $table->integer('achievements_count')->default(0);
            $table->integer('quests_completed')->default(0);
            $table->integer('positive_points')->default(0);
            $table->integer('negative_points')->default(0);
            $table->integer('rewards_earned')->default(0);
            $table->integer('points')->default(0);
            $table->integer('login_streak')->default(0);
            
            // Educational Counters
            $table->integer('homework_completed')->default(0);
            $table->integer('books_read')->default(0);
            $table->integer('peers_helped')->default(0);
            $table->integer('creative_projects')->default(0);
            $table->integer('students_mentored')->default(0);
            $table->integer('weekly_positive')->default(0);
            $table->integer('weekly_tasks')->default(0);
            $table->integer('weekly_xp')->default(0);
            
            // Misc
            $table->timestamp('last_login')->nullable();
            $table->boolean('first_character_selection')->default(false);
            
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
