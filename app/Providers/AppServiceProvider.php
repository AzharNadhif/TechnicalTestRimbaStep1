<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{

    Gate::define('view-users', function (User $user) {
        return in_array($user->role, ['admin', 'manager']);
    });

    Gate::define('create-user', function (User $user) {
        return $user->role === 'admin';
    });

    Gate::define('view-logs', function (User $user) {
        return $user->role === 'admin';
    });

    Gate::define('create-task', function (User $user) {
        return $user->role === 'admin';
    });

    Gate::define('assign-task', function (User $user, $assignedTo) {
        // Manager hanya bisa assign ke staff
        if ($user->role === 'manager' && $assignedTo->role !== 'staff') {
            return false;
        }
        return true;
    });

    Gate::define('view-task', function (User $user, $task) {
        return $task->created_by === $user->id || $task->assigned_to === $user->id;
    });

    Gate::define('delete-task', function (User $user, $task) {
        return $user->role === 'admin' || $task->created_by === $user->id;
    });
    
}
}
