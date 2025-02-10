<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\User;
use App\Form\CandidateType;
use App\Form\RegistrationFormType;
use App\Service\FileUploader;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use function Symfony\Component\Clock\now;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(CandidateRepository $candidateRepository, Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        /**
         * @var User $user
         */
        $user = $this->getUser();


        $candidate = $candidateRepository->findOneBy(["user" => $this->getUser()]);



        
        if ($candidate === null) {
            
            $candidate = new Candidate();
            $candidate->setUser($user);
        }

        if(!$user->isVerified())
        {
            return $this->render('errors/not-verified.html.twig', [

            ]);
        }

        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if( $candidate->getCreatedAt() === null) {
                $candidate->setCreatedAt(new \DateTimeImmutable());
            }

            $profilePictureFile = $form->get('profilePictureFile')->getData();
            // $passportFile = $form->get('passportFile')->getData();
            // $curriculumVitaeFile = $form->get('curriculumVitaeFile')->getData();

            if($profilePictureFile){
                $profilPictureName = $fileUploader->upload($profilePictureFile, $candidate, 'profilePicture', 'profile_pictures');
                $candidate->setProfilePicture($profilPictureName);
            }

            // if ($passportFile) {
            //     $passportFileName = $fileUploader->upload($passportFile, $candidate, 'passport', 'passport_files');
            //     $candidate->setPassport($passportFileName);
            // }

            // if ($curriculumVitaeFile) {
            //     $curriculumVitaeFileName = $fileUploader->upload($curriculumVitaeFile, $candidate, 'curriculumVitae', 'cv_files');
            //     $candidate->setCurriculumVitae($curriculumVitaeFileName);
            // }


            // Todo : cv & passport

            $candidate->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->persist($candidate);
            $entityManager->flush();
            $this->addFlash('success', "Your profile has been updated!");
        }


        return $this->render('profile/profile.html.twig', [
            'candidateForm' => $form,
            'candidate' => $candidate,
            
        ]);
    }
}
