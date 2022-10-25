<?php

namespace App\Providers;

use App\Contracts\UserContract;

use App\Repositories\UserRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    protected array $repositories = [
        UserContract::class  => UserRepository::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
