<?php

namespace App\Controller;


use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        /** @var User */
        $user = $this->getUser();
        $data = new ContactDTO();


        // On préremplit directement dans le DTO les infos ultilisateurs déja donnée (on sfait pas chiera le mettre dans le template twig, c'est mieux comme ça, les infos sont déja hydratées)

        if ($user) {
            $data->email = $user->getEmail();

            $candidate = $user->getCandidate();
            if ($candidate) {
                $data->firstName = $candidate->getFirstName();
                $data->lastName = $candidate->getLastName();
            }

        }


        $form = $this->createForm(ContactType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $mail = (new TemplatedEmail())
                ->from($data->email)
                ->to('contact@luxury.com')
                ->subject('Demande de contact')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'data' => $data
                ]);
                    $mailer->send($mail);
                    $this->addFlash('success', 'Votre message a bien été envoyé');
                    return $this->redirectToRoute('app_contact');       
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Une erreur est survenue, veuillez contacter le support avec ce message :' . $e->getMessage());
                return $this->redirectToRoute("app_contact");
            }

        }


            return $this->render('contact/contact.html.twig', [
                'form' => $form,
        ]);

    }
}