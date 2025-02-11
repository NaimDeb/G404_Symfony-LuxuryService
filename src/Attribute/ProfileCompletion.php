<?php
namespace App\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class ProfileCompletion
{

    public bool $enabled;


    public function __construct(bool $enabled = true)
    {
    }
}


?>