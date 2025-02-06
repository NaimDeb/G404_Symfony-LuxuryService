<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JobController extends AbstractController
{
    #[Route('/job', name: 'app_job')]
    public function index(): Response
    {
        return $this->render('jobs/index.html.twig', [
        ]);
    }
    
    #[Route('/job/show', name: 'app_job_show')]
    public function show(): Response
    {
        return $this->render('jobs/show.html.twig', [
        ]);
    }

}
