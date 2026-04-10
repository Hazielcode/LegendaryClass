<?php

namespace App\Providers;

use App\Models\Behavior;
use App\Models\Reward;
use App\Policies\BehaviorPolicy;
use App\Policies\RewardPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Behavior::class => BehaviorPolicy::class,
        Reward::class => RewardPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gates adicionales para gamificación
        Gate::define('manage-classroom', function ($user, $classroom) {
            return $user->role === 'teacher' && $classroom->teacher_id === $user->id;
        });

        Gate::define('view-student-data', function ($user, $student, $classroom) {
            if ($user->role === 'admin') return true;
            if ($user->role === 'teacher') {
                return $classroom->teacher_id === $user->id;
            }
            if ($user->role === 'student') {
                return $user->id === $student->id;
            }
            return false;
        });

        Gate::define('award-behavior', function ($user, $classroom) {
            return $user->role === 'teacher' && $classroom->teacher_id === $user->id;
        });

        Gate::define('redeem-reward', function ($user, $reward) {
            return $user->role === 'student' && 
                   in_array($reward->classroom_id, $user->classroom_ids ?? []) && 
                   $reward->is_active;
        });

        Gate::define('manage-students', function ($user, $classroom) {
            return $user->role === 'teacher' && $classroom->teacher_id === $user->id;
        });
    }
}