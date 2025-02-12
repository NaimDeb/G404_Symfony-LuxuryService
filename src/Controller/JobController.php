<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Repository\JobCategoryRepository;
use App\Repository\JobOfferRepository;
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
    
    #[Route('/job/show/{id}', name: 'app_job_show')]
    public function show(JobOffer $offer): Response
    {

        



        $user = $this->getUser();


        return $this->render('jobs/show.html.twig', [
            "user" => $user,
            "offers" => $offer
        ]);
    }

}
