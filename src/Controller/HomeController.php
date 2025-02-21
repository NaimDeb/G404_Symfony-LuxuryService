<?php

namespace App\Controller;

use App\Entity\JobCategory;
use App\Repository\JobCategoryRepository;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(JobOfferRepository $jobOfferRepository, JobCategoryRepository $jobCategoryRepository): Response
    {

        $jobCategories = $jobCategoryRepository->findAll();


        $jobOffers = $jobOfferRepository->getJobOffersWithApplicationStatus(6, user: $this->getUser());



        $user = $this->getUser();
        return $this->render('home/index.html.twig', [
            "user" => $user,
            "categories" => $jobCategories,
            "offers" => $jobOffers
        ]);
    }

}



