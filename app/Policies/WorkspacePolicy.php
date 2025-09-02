<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;

class WorkspacePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Workspace $workspace): bool{
        return $user->workspaces()->whereKey($workspace->id)->exists();
    }
}
