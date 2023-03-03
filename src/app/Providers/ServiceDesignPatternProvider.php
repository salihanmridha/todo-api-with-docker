<?php

namespace App\Providers;

use App\Services\Contracts\TaskServiceInterface;
use App\Services\Contracts\TodoServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\TaskService;
use App\Services\TodoService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceDesignPatternProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(TodoServiceInterface::class, TodoService::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
