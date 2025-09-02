<?php

namespace App\Domain\Workspaces\Contracts;

use App\Domain\Workspaces\Entities\WorkspaceEntity;

interface WorkspaceRepositoryPort {
    /** @return WorkspaceEntity[] */
    public function listByUser(int $userId): array;
    public function create(string $name, int $ownerUserId): WorkspaceEntity;
    public function findById(int $id): ?WorkspaceEntity;
    public function userBelongsTo(int $workspaceId, int $userId): bool;
}