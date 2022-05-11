<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('create-task_status', function (User $user) {
            return true;
        });
        Gate::define('update-task_status', function (User $user) {
            return true;
        });
        Gate::define('delete-task_status', function (User $user) {
            return true;
        });

        Gate::define('create-task', function (User $user) {
            return true;
        });
        Gate::define('edit-task', function (User $user) {
            return true;
        });
        Gate::define('delete-task', function (User $user, Task $task) {
            return $user->id === $task->creator()->id;
        });

        //
    }
}
