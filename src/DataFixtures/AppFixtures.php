<?php

namespace App\DataFixtures;

use App\Entity\Gender;
use App\Entity\JobCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // Create genders

        $genderList = ['Male', 'Female', 'Other'];

        foreach ($genderList as $gender) {
            $genderClass = new Gender();
            $genderClass->setName($gender);
            $manager->persist($genderClass);
        }

        // Categories

        $categoryList = [
            "Commercial",
            "Retail sales",
            "Creative",
            "Technology",
            "Marketing & PR",
            "Fashion & luxury",
            "Management & HR"
        ];

        foreach ($categoryList as $jobCategory) {
            $jobCategoryClass = new JobCategory();
            $jobCategoryClass->setName($jobCategory);
            $manager->persist($jobCategoryClass);
        }

        $manager->flush();
    }
}
