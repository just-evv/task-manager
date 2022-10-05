<?php

namespace App\Policies;

use App\Models\{Task, User};
use Illuminate\Auth\Access\{HandlesAuthorization, Response};
use Illuminate\Support\Facades\Auth;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the User can see all models.
     * @param User $user
     * @return bool
     */

    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the User can see the model.
     * @param User $user
     * @return bool
     */
    public function view(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user have access to edit modest page.
     *
     * @param User $user
     * @return Response|bool
     */
    public function update(User $user): Response|bool
    {
        return Auth::check();
    }

    public function edit(User $user): Response|bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Task $task
     * @return Response|bool
    */
    public function delete(User $user, Task $task): Response|bool
    {
        return $user->id === $task->created_by_id;
    }
}
