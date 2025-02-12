<?php

namespace App\DTO;

// Tt en public tt en nullable car c'est une classe de transfert (Data Transfer Object)

use Symfony\Component\Validator\Constraints as Assert;


class ContactDTO
{
    #[Assert\NotBlank]
    public ?string $firstName;
    #[Assert\NotBlank]
    public ?string $lastName;

    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $email;

    
    public ?string $phoneNumber;

    #[Assert\NotBlank]
    public ?string $message;
}