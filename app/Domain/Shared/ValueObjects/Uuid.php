<?php

namespace App\Domain\Shared\ValueObjects;

readonly class Uuid
{
    public function __construct(public string $value)
    {
        // Acepta UUID “ordenables” (formato estándar) y UUID normales
        if (!preg_match('/^[0-9a-fA-F-]{36}$/', $this->value)) {
            throw new \InvalidArgumentException('UUID inválido');
        }
    }

    public function __toString(): string { return $this->value; }
}