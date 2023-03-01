<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\Auth\UserRepositoryInterface;
use App\Http\Repositories\Auth\UserRepository;

class UserRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
