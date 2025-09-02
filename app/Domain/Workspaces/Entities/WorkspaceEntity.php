<?php

namespace App\Domain\Workspaces\Entities;

class WorkspaceEntity {
    public function __construct(
        public int $id,
        public string $name,
        public int $owner_user_id,
        public ?string $slug = null
    ) {}

    public static function fromArray(array $a): self {
        return new self(
            id: (int)$a['id'],
            name: (string)$a['name'],
            owner_user_id: (int)$a['owner_user_id'],
            slug: $a['slug'] ?? null
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'owner_user_id' => $this->owner_user_id,
            'slug' => $this->slug,
        ];
    }
}