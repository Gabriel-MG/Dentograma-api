<?php

namespace App\Domain\Workspaces\UseCases;

use App\Domain\Workspaces\Contracts\WorkspaceRepositoryPort;
use App\Domain\Workspaces\Entities\WorkspaceEntity;

readonly class CreateWorkspace {
    public function __construct(private WorkspaceRepositoryPort $repo) {}
    public function __invoke(string $name, int $ownerUserId): WorkspaceEntity {
        // Reglas simples (podrás mover a Services si crecen)
        $name = trim($name);
        if ($name === '') { throw new \InvalidArgumentException('Name required'); }
        return $this->repo->create($name, $ownerUserId);
    }
}