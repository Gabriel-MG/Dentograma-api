<?php

namespace App\Domain\Patient\Contracts;

use App\Domain\Patient\Entities\Patient;
use App\Domain\Shared\ValueObjects\PatientId;
use App\Domain\Shared\ValueObjects\WorkspaceId;

interface PatientRepositoryPort
{
    public function store(Patient $patient): void;

    /** Seguridad multi-tenant: siempre filtra por workspace */
    public function findById(PatientId $id, WorkspaceId $workspaceId): ?Patient;
}