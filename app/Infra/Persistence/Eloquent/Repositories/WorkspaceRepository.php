<?php

namespace App\Infra\Persistence\Eloquent\Repositories;

use App\Domain\Workspaces\Contracts\WorkspaceRepositoryPort;
use App\Domain\Workspaces\Entities\WorkspaceEntity;
use App\Models\Workspace;

class WorkspaceRepository implements WorkspaceRepositoryPort
{

    public function listByUser(int $userId): array {
        $rows = Workspace::query()->select('workspaces.*')
            ->join('workspace_users','workspace_users.workspace_id','=','workspaces.id')
            ->where('workspace_users.user_id',$userId)
            ->orderBy('workspaces.created_at','desc')
            ->get()
            ->toArray();

        return array_map(fn($r) => WorkspaceEntity::fromArray($r), $rows);
    }

    public function create(string $name, int $ownerUserId): WorkspaceEntity {
        $ws = Workspace::query()->create([
            'name' => $name,
            'owner_user_id' => $ownerUserId,
        ]);
        // vincular como owner
        $ws->users()->syncWithoutDetaching([$ownerUserId => ['role' => 'owner']]);
        return WorkspaceEntity::fromArray($ws->toArray());
    }

    public function findById(int $id): ?WorkspaceEntity {
        $ws = Workspace::query()->find($id);
        return $ws ? WorkspaceEntity::fromArray($ws->toArray()) : null;
    }

    public function userBelongsTo(int $workspaceId, int $userId): bool {
        return Workspace::query()->where('id',$workspaceId)
            ->whereHas('users', fn($q)=>$q->where('user_id',$userId))
            ->exists();
    }
}