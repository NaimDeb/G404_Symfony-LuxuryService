<?php

namespace App\DataFixtures;

use App\Entity\JobCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class JobCategoryFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger) {}

    public function load(ObjectManager $manager): void
    {
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
