<?php

namespace App\Policies;

use App\Models\Behavior;
use App\Models\User;
use App\Models\Classroom;

class BehaviorPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'teacher' || $user->role === 'admin';
    }

    public function view(User $user, Behavior $behavior)
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'teacher') {
            $classroom = Classroom::find($behavior->classroom_id);
            return $classroom && $classroom->teacher_id === $user->id;
        }

        if ($user->role === 'student') {
            return in_array($behavior->classroom_id, $user->classroom_ids ?? []);
        }

        return false;
    }

    public function create(User $user)
    {
        return $user->role === 'teacher' || $user->role === 'admin';
    }

    public function update(User $user, Behavior $behavior)
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'teacher') {
            $classroom = Classroom::find($behavior->classroom_id);
            return $classroom && $classroom->teacher_id === $user->id;
        }

        return false;
    }

    public function delete(User $user, Behavior $behavior)
    {
        return $this->update($user, $behavior);
    }
}