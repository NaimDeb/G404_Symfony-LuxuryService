<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Repository\JobApplicationRepository;
use App\Repository\JobCategoryRepository;
use App\Repository\JobOfferRepository;
use App\Service\CandidateCompletionCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JobController extends AbstractController
{
    #[Route('/jobs/{page<\d+>?1}', name: 'app_job')]
    public function index(int $page, JobOfferRepository $jobOfferRepository, JobCategoryRepository $jobCategoryRepository): Response
    {

        $jobCategories = $jobCategoryRepository->findAll();

        // Todo : ajax pagination
        
        $jobOffers = $jobOfferRepository->getJobOffersWithApplicationStatus(10, $page, user: $this->getUser());

        $user = $this->getUser();


        return $this->render('jobs/index.html.twig', [

            "user" => $user,
            "categories" => $jobCategories,
            "offers" => $jobOffers
        ]);
    }
    
    #[Route('/job/show/{slug}_{id}', name: 'app_job_show')]
    public function show(JobOffer $offer, CandidateCompletionCalculator $completionCalculator, JobApplicationRepository $applicationRepository, JobCategoryRepository $categoryRepository ): Response
    {
        /** @var User */
        $user = $this->getUser();

        if(!$user){
            return $this->redirectToRoute('app_login');
        }

        $candidate = $user->getCandidate();



        // Check if the user has already applied for this offer
        $isApplied = $applicationRepository->findOneBy([
            'candidate' => $candidate,
            'jobOffer' => $offer
        ]) !== null;



        $completionRate = $completionCalculator->calculateCompletion($candidate);

        


        /** @var JobOfferLinkDTO */
        $adjacentOffers = $categoryRepository->findAdjacentOffers($offer);

        $previousOffer = $adjacentOffers['previous'];
        $nextOffer = $adjacentOffers['next'];

        
        return $this->render('jobs/show.html.twig', [
            "user" => $user,
            "offer" => $offer,
            "isApplied" => $isApplied,
            "completionRate" => $completionRate,
            "nextOffer" => $nextOffer,
            "previousOffer" => $previousOffer

        ]);
    }
}
