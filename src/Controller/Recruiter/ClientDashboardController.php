<?php

namespace App\Controller\Recruiter;

use App\Entity\Client;
use App\Entity\JobApplication;
use App\Entity\JobOffer;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AdminDashboard(routePath: '/recruiter', routeName: 'recruiter')]
class ClientDashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {

    }

    #[Route("/recruiter")]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('recruiter/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TPLuxury');
    }

    

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('My account', 'fas fa-user-circle');
        
        // Todo : change linktocrud to directly edit the current user

        /** @var User */
        $user = $this->getUser();
        $client = $user->getClient();


        $userUrl = $this->adminUrlGenerator
            ->setController(RecruiterUserCrudController::class)
            ->setAction('edit')
            ->setEntityId($user->getId())
            ->generateUrl();


        yield MenuItem::linkToUrl('My Profile info', 'fas fa-id-card', $userUrl);

        $clientUrl = $this->adminUrlGenerator
        ->setController(RecruiterClientCrudController::class)
        ->setAction('edit')
        ->setEntityId($client->getId())
        ->generateUrl();

        yield MenuItem::linkToUrl('My information', 'fas fa-info-circle', $clientUrl);

        yield MenuItem::section('My offers', 'fas fa-briefcase');

        yield MenuItem::linkToCrud('My Job Offers', 'fas fa-business-time', JobOffer::class)
            ->setController(RecruiterJobOfferCrudController::class);
        yield MenuItem::linkToCrud('Candidate Applications', 'fas fa-file-signature', JobApplication::class)
            ->setController(RecruiterJobApplicationCrudController::class);



    }
}
