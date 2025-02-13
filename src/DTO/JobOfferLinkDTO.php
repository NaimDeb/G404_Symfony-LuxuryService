<?php

namespace App\DTO;

class JobOfferLinkDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $slug,
    ) {
    }
}