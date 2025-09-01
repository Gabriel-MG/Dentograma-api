<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AuditServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Activity::saving(function (Activity $activity) {
            $activity->workspace_id = app()->has('activeWorkspace') ? app('activeWorkspace')->id : null;
            if (request()) {
                $activity->ip = request()->ip();
                $activity->user_agent = request()->userAgent();
            }
        });
    }
}
