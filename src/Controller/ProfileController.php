<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\User;
use App\Form\CandidateType;
use App\Form\RegistrationFormType;
use App\Interfaces\FileHandlerInterface;
use App\Interfaces\PasswordUpdaterInterface;
use App\Service\FileUploader;
use App\Repository\CandidateRepository;
use App\Service\CandidateCompletionCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use function Symfony\Component\Clock\now;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(
        CandidateRepository $candidateRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        CandidateCompletionCalculator $completionCalculator,
        FileHandlerInterface $fileHandler,
        PasswordUpdaterInterface $passwordUpdater
    ): Response 
    {


        /**
         * @var User $user
         */
        $user = $this->getUser();

        $candidate = $candidateRepository->findOneBy(["user" => $this->getUser()]);

                
        if(!$user->isVerified()) {
            return $this->render('errors/not-verified.html.twig');
        }


        // Crée un candidat quand on va dans le profil.
        // Todo : delay creation to when I you fill the form
        if ($candidate === null) {
            $candidate = new Candidate();
            $candidate->setUser($user);
        }


        // Completion rate for candidate

        $completionRate = $completionCalculator->calculateCompletion($candidate);


        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if( $candidate->getCreatedAt() === null) {
                $candidate->setCreatedAt(new \DateTimeImmutable());
            }


            // Handle file uploading

            $files = [
                'profilePicture' => $form->get('profilePictureFile')->getData(),
                'passport' => $form->get('passportFile')->getData(),
                'curriculumVitae' => $form->get('curriculumVitaeFile')->getData(),
            ];
            $fileHandler->handleFiles($candidate, $files);


            // Password and mail

            $email = $form->get('email')->getData();
            $newPassword = $form->get('newPassword')->getData();

            if ($email && $newPassword) {
                $passwordUpdater->updatePassword($user, $email, $newPassword);
            } elseif ($email || $newPassword) {
                $this->addFlash('danger', 'Email and password must be filled together to change password.');
            }


            // Todo : password

            $candidate->setUpdatedAt(new \DateTimeImmutable());

            // Recalculate completion rate
            // $this->setCandidateStatus($user, $completionRate, $entityManager);
            
            $entityManager->persist($candidate);
            $entityManager->flush();
            $this->addFlash('success', "Your profile has been updated!");
            $this->redirect('app_profile');

            return $this->redirectToRoute("app_profile");
        }

        return $this->render('profile/profile.html.twig', [
            'candidateForm' => $form,
            'candidate' => $candidate,
            'completionRate' => $completionRate,

            'originalProfilPicture' => $this->getOriginalFilename($candidate->getProfilePicture()),
            'originalPassport' => $this->getOriginalFilename($candidate->getPassport()),
            'originalCv' => $this->getOriginalFilename($candidate->getCurriculumVitae()),
            
        ]);


    }

    // #[Route('/delete_account/{token}', name: 'delete_account')]
    // public function index() {
        
    // }



    private function getOriginalFilename(?string $filename): ?string
    {
        return $filename ? preg_replace('/-\w{13}(?=\.\w{3,4}$)/', '', $filename) : null;
    }


    // Give role to user if needed
    // private function setCandidateStatus(User $user, EntityManagerInterface $entityManager) {

    //     $userRoles = $user->getRoles();	

        

    //     if ($completionRate === 100 && !in_array('ROLE_CANDIDATE', $userRoles, true)) {
    //         $user->addRole('ROLE_CANDIDATE');
    //     }
    //     else if ($completionRate < 100 && in_array('ROLE_CANDIDATE', $userRoles, true)) {
    //         $user->removeRole('ROLE_CANDIDATE');
    //     }

    //     // dd($completionRate, in_array('ROLE_CANDIDATE', $userRoles, true), $userRoles );

    //     $entityManager->persist($user);
    // }
}
