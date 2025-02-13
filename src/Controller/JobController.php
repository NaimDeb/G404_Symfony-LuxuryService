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
    #[Route('/job', name: 'app_job')]
    public function index(JobOfferRepository $jobOfferRepository, JobCategoryRepository $jobCategoryRepository): Response
    {

        $jobOffers = $jobOfferRepository->findAll();

        $jobCategories = $jobCategoryRepository->findAll();

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

        // Todo: Get the previous and next somewhere else

        // Query for the previous offer
        // SELECT * FROM job_category 
        $previousOffer = $categoryRepository->createQueryBuilder('jobCategory')
            // JOIN job_offer (ON est fait automatiquement par Doctrine)
            ->join('jobCategory.jobOffers', 'jobOffer')

            // On récupère seulement l'id et le slug
            // Self explanatory
            ->select('jobOffer.id, jobOffer.slug')

            // On récupère seulement les offres de la même catégorie
            // WHERE job.category.id = Id de la catégorie de l'offre en cours
            ->where('jobCategory.id = :categoryId')
            // On récupère les offres qui sont avant la date de l'offre en cours
            // AND WHERE created.At < createdAt de l'offre en cours
            ->andWhere('jobOffer.createdAt < :currentOfferDate')

            ->setParameter('categoryId', $offer->getCategory()->getId())
            ->setParameter('currentOfferDate', $offer->getCreatedAt())
            
            // On ordonne les offres par date de création DESC
            // ORDER BY jobOffer.createdAt DESC
            ->orderBy('jobOffer.createdAt', 'DESC')

            // On récupère un seul résultat
            // LIMIT 1
            ->setMaxResults(1)
            ->getQuery()
            // Si on a aucun résultat, donne Null
            ->getOneOrNullResult();

        $nextOffer = $categoryRepository->createQueryBuilder('jobCategory')
            ->join('jobCategory.jobOffers', 'jobOffer')
            ->select('jobOffer.id, jobOffer.slug')
            ->where('jobCategory.id = :categoryId')
            ->andWhere('jobOffer.createdAt > :currentOfferDate')
            ->setParameter('categoryId', $offer->getCategory()->getId())
            ->setParameter('currentOfferDate', $offer->getCreatedAt())
            ->orderBy('jobOffer.createdAt', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();





        
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
