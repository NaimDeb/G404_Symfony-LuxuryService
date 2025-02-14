<?php

namespace App\DTO;

class JobOfferCardDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $categorySlug,
        public readonly string $description,
        public readonly string $jobTitle,
        public readonly string $location,
        public readonly string $salary,
        public readonly \DateTimeInterface $createdAt,
        public readonly string $slug,
        public readonly bool $isApplied = false
    ) {
    }
}