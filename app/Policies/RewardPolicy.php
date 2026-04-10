<?php

namespace App\Policies;

use App\Models\Reward;
use App\Models\User;

class RewardPolicy
{
    public function view(User $user, Reward $reward)
    {
        if ($user->hasAdminAccess()) {
            return true;
        }

        if ($user->role === 'teacher') {
            $classroom = $reward->classroom;
            return $classroom && $classroom->teacher_id === $user->id;
        }

        if ($user->role === 'student') {
            return in_array($reward->classroom_id, $user->classroom_ids ?? []);
        }

        return false;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['teacher', 'admin']);
    }

    public function update(User $user, Reward $reward)
    {
        if ($user->hasAdminAccess()) {
            return true;
        }

        if ($user->role === 'teacher') {
            $classroom = $reward->classroom;
            return $classroom && $classroom->teacher_id === $user->id;
        }

        return false;
    }

    public function delete(User $user, Reward $reward)
    {
        return $this->update($user, $reward);
    }
}