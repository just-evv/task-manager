<?php

namespace App\Policies;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

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
        return Auth::check();
    }
    /**
     * Determine whether the user can accesses the edit model page.
     *
     * @param User $user
     * @return Response|bool
     */
    public function edit(User $user): Response|bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function update(User $user): Response|bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function delete(User $user): Response|bool
    {
        return Auth::check();
    }
}
