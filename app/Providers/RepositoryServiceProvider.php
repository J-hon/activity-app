<?php

namespace App\Providers;

use App\Contracts\ActivityContract;
use App\Contracts\RevisionContract;
use App\Contracts\UserContract;

use App\Repositories\ActivityRepository;
use App\Repositories\RevisionRepository;
use App\Repositories\UserRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    protected array $repositories = [
        UserContract::class     => UserRepository::class,
        ActivityContract::class => ActivityRepository::class,
        RevisionContract::class => RevisionRepository::class
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
