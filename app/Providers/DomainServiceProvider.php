<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Workspaces\Contracts\WorkspaceRepositoryPort::class,
            \App\Infra\Persistence\Eloquent\Repositories\WorkspaceRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
