<?php

namespace App\Policies;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TaskStatusPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        if ($user) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param TaskStatus $taskStatus
     * @return Response|bool
     */
    public function update(User $user, TaskStatus $taskStatus): Response|bool
    {
        if ($user) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param TaskStatus $taskStatus
     * @return Response|bool
     */
    public function delete(User $user, TaskStatus $taskStatus): Response|bool
    {
        if ($user) {
            return true;
        }
    }
}