<?php

namespace App\DataFixtures;

use App\Entity\Candidate;
use App\Entity\Gender;
use App\Entity\JobCategory;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CandidateFixtures extends Fixture
{
    public const CANDIDATES_DATA = [
        'test' => [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'currentLocation' => 'Paris',
            'address' => '123 Avenue des Champs-Élysées',
            'country' => 'France',
            'nationality' => 'French',
            'birthDate' => '1990-05-15',
            'birthPlace' => 'Lyon',
            'description' => 'Experienced professional with a strong background in luxury retail.',
            'notes' => 'Available for immediate start',
            'completionPercentage' => 100
        ],
        'test2' => [
            'firstName' => 'Emma',
            'lastName' => 'Smith',
            'currentLocation' => 'London',
            'address' => '45 Oxford Street',
            'country' => 'United Kingdom',
            'nationality' => 'British',
            'birthDate' => '1988-12-03',
            'birthPlace' => 'Manchester',
            'description' => 'Fashion industry expert with 10+ years experience.',
            'notes' => 'Seeking opportunities in Paris',
            'completionPercentage' => 100
        ],
        'test3' => [
            'firstName' => 'Marco',
            'lastName' => 'Rossi',
            'currentLocation' => 'Milan',
            'address' => 'Via Montenapoleone, 8',
            'country' => 'Italy',
            'nationality' => 'Italian',
            'birthDate' => '1992-07-21',
            'birthPlace' => 'Rome',
            'description' => 'Creative director with expertise in luxury brands.',
            'notes' => 'Available for remote work',
            'completionPercentage' => 100
        ],
        'test4' => [
            'firstName' => 'Sophie',
            'lastName' => 'Martin',
            'currentLocation' => 'Geneva',
            'address' => '15 Rue du Rhône',
            'country' => 'Switzerland',
            'nationality' => 'Swiss',
            'birthDate' => '1991-09-28',
            'birthPlace' => 'Zurich',
            'description' => 'Specialized in luxury timepiece industry.',
            'notes' => 'Looking for management positions',
            'completionPercentage' => 100
        ],
        'test5' => [
            'firstName' => 'Hans',
            'lastName' => 'Weber',
            'currentLocation' => 'Munich',
            'address' => 'Maximilianstraße 25',
            'country' => 'Germany',
            'nationality' => 'German',
            'birthDate' => '1987-03-14',
            'birthPlace' => 'Berlin',
            'description' => 'Expert in luxury automotive sector.',
            'notes' => 'Open to international relocation',
            'completionPercentage' => 100
        ],
        'test6' => [
            'firstName' => 'Maria',
            'lastName' => 'Garcia',
            'currentLocation' => 'Madrid',
            'address' => 'Calle de Serrano, 47',
            'country' => 'Spain',
            'nationality' => 'Spanish',
            'birthDate' => '1993-11-05',
            'birthPlace' => 'Barcelona',
            'description' => 'Luxury hospitality professional.',
            'notes' => 'Fluent in 4 languages',
            'completionPercentage' => 100
        ]
    ];


    public function load(ObjectManager $manager): void
    {
        foreach (self::CANDIDATES_DATA as $key => $candidateData) {
            $candidate = new Candidate();

            try {
                // Récupérer l'utilisateur correspondant
                $user = $this->getReference('user_' . $key, User::class);
                $candidate->setUser($user);

                // Données de base
                $candidate->setFirstName($candidateData['firstName']);
                $candidate->setLastName($candidateData['lastName']);
                $candidate->setCurrentLocation($candidateData['currentLocation']);
                $candidate->setAddress($candidateData['address']);
                $candidate->setCountry($candidateData['country']);
                $candidate->setNationality($candidateData['nationality']);
                $candidate->setBirthDate(new DateTimeImmutable($candidateData['birthDate']));
                $candidate->setPlaceOfBirth($candidateData['birthPlace']);
                $candidate->setShortDescription($candidateData['description']);
                $candidate->setNotes($candidateData['notes']);

                // Références aux autres entités
                try {
                    $gender = $this->getReference('gender_' . strtolower(random_array_element(['male', 'female', 'other'])), Gender::class);
                    $candidate->setGender($gender);
                } catch (\Exception $e) {
                    // Log or handle the gender reference error
                }

                try {
                    $jobCategory = $this->getReference('category_' . strtolower(random_array_element(['commercial', 'retail_sales', 'creative', 'technology', 'marketing_pr', 'fashion_luxury', 'management_hr'])), JobCategory::class);
                    $candidate->setJobCategory($jobCategory);
                } catch (\Exception $e) {
                    // Log or handle the job category reference error
                }

                try {
                    $experience = strtolower(str_replace([' ', '+'], '_', random_array_element(['0 - 6 months', '6 months - 1 year', '1 - 2 years', '2+ years', '5+ years', '10+ years'])));
                    $candidate->setExperience($experience);
                } catch (\Exception $e) {
                    // Log or handle the experience error
                }

                $manager->persist($candidate);
                $this->addReference('candidate_' . $key, $candidate);
            } catch (\Exception $e) {
                // Skip this candidate if the user reference doesn't exist
                continue;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            GenderFixtures::class,
            JobCategoryFixtures::class,
        ];
    }
}

function random_array_element(array $array)
{
    return $array[array_rand($array)];
}
