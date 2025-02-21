<?php

namespace App\DataFixtures;

use App\Entity\Gender;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genderList = ['Male', 'Female', 'Other'];

        foreach ($genderList as $gender) {
            $genderClass = new Gender();
            $genderClass->setName($gender);
            $manager->persist($genderClass);
        }

        $manager->flush();
    }
}
