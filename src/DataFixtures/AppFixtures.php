<?php

namespace App\DataFixtures;

use App\Entity\Gender;
use App\Entity\JobApplication;
use App\Entity\JobCategory;
use App\Entity\JobOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{

    public function __construct(private SluggerInterface $slugger)
    {}

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
            "Commercial" => "",
            "Retail sales" => "",
            "Creative" => "",
            "Technology" => "",
            "Marketing & PR" => "",
            "Fashion & luxury" => "",
            "Management & HR" => "",
        ];



        foreach ($categoryList as $jobCategory => $jobSlugger) {


            $jobSlugger = $this->slugger->slug($jobCategory);

            $jobCategoryClass = new JobCategory();
            $jobCategoryClass->setName($jobCategory);
            $jobCategoryClass->setSlug($jobSlugger);
            $manager->persist($jobCategoryClass);
        }


        $manager->flush();
    }
}
