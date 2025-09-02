<?php

namespace App\Domain\Workspaces\UseCases;

use App\Domain\Workspaces\Contracts\WorkspaceRepositoryPort;

readonly class ListMyWorkspaces {
    public function __construct(private WorkspaceRepositoryPort $repo) {}
    public function __invoke(int $userId): array {
        return $this->repo->listByUser($userId);
    }
}