<?php

namespace App\Controller;

use App\Entity\JobApplication;
use App\Entity\JobOffer;
use App\Form\JobApplicationType;
use App\Repository\JobApplicationRepository;
use App\Repository\JobOfferRepository;
use App\Service\CandidateCompletionCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/apply')]
final class JobApplicationController extends AbstractController
{
    #[Route( name: 'job_apply', methods: ['GET', 'POST'])]
    public function apply(Request $request, CandidateCompletionCalculator $completionCalculator, EntityManagerInterface $entityManager): Response
    {
        /** @var User */
        $user = $this->getUser();

        if (!$user) { return $this->redirectToRoute('app_login'); }
        
        $candidate = $user->getCandidate();

        $userRoles = $user->getRoles();

        $jobOffer = $entityManager->getRepository(JobOffer::class)->findOneBy(['id' => $request->query->get('id')]);

        // Failsafe if user is not a candidate (don't care for admin)
        if (!$candidate || !in_array('ROLE_CANDIDATE', $userRoles) && !in_array('ROLE_ADMIN', $userRoles)) {
            $this->addFlash("error", "You are not a candidate");
            return $this->redirectToRoute('app_profile'); 
        }

        // Failsafe if job offer not found
        if (!$jobOffer) {
            $this->addFlash("error", "Job offer not found");
            return $this->redirectToRoute('app_job'); 
        }

        $candidature = $entityManager->getRepository(JobApplication::class)->findBy([
            'candidate' => $candidate,
            'jobOffer' => $jobOffer
        ]);

        // Failsafe if already applied
        if ($candidature) {
            $this->addFlash("error", "You already applied for this offer");
            return $this->redirectToRoute('app_job'); 
        }
        


        // * Create jobApplication

        $jobApplication = new JobApplication;

        $jobApplication->setCandidate($candidate);
        $jobApplication->setJobOffer($jobOffer);


        $form = $this->createForm(JobApplicationType::class, $jobApplication);
        $form->handleRequest($request);


        
        $entityManager->persist($jobApplication);
        $entityManager->flush();



        
        // Redirect back
        return $this->redirect($request->headers->get('referer'));
    }
}
