<?php

namespace App\Domain\Patient\Entities;

use App\Domain\Shared\ValueObjects\PatientId;
use App\Domain\Shared\ValueObjects\WorkspaceId;

class Patient
{
    public function __construct(
        public readonly PatientId $id,
        public readonly WorkspaceId $workspaceId,
        public string $fullName,
        public ?string $email,
        public ?string $phone,
    ) {
        if ($this->fullName === '') {
            throw new \InvalidArgumentException('El nombre no puede ser vacío');
        }
    }

    public static function create(
        PatientId $id,
        WorkspaceId $ws,
        string $fullName,
        ?string $email,
        ?string $phone
    ): self {
        return new self($id, $ws, trim($fullName), $email, $phone);
    }
}