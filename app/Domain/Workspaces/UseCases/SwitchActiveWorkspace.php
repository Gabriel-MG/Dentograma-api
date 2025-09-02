<?php

namespace App\Domain\Workspaces\UseCases;


use App\Domain\Workspaces\Contracts\WorkspaceRepositoryPort;

readonly class SwitchActiveWorkspace {
    public function __construct(private WorkspaceRepositoryPort $repo) {}
    public function __invoke(int $workspaceId, int $userId): int {
        if (!$this->repo->userBelongsTo($workspaceId, $userId)) {
            throw new \DomainException('Forbidden workspace');
        }
        return $workspaceId;
    }
}