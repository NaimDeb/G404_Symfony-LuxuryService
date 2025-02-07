<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\User;
use App\Form\CandidateType;
use App\Form\RegistrationFormType;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(CandidateRepository $candidateRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        /**
         * @var User $user
         */
        $user = $this->getUser();


        $candidate = $candidateRepository->findOneBy(["User" => $this->getUser()]);

        
        if ($candidate === null) {
            
            $candidate = new Candidate();
            $candidate->setUser($user);
        }
        dd($candidate);

        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
        }

        return $this->render('profile/profile.html.twig', [
            'candidateForm' => $form,
            
        ]);
    }
}
