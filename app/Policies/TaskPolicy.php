<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    public function view(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }

    public function create(User $user)
    {
        return true; // Allow all authenticated users to create tasks
    }

    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id; // Users can only update their own tasks
    }

    public function delete(User $user, Task $task)
    {
        return $user->id === $task->user_id; // Users can only delete their own tasks
    }
}
