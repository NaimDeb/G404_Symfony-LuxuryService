<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use App\Entity\Client;
use App\Entity\Gender;
use App\Entity\JobApplication;
use App\Entity\JobCategory;
use App\Entity\JobOffer;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route("/admin")]
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
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TPLuxury')
            ->setFaviconPath('img/luxury-services-logo.png');
    }

    public function configureMenuItems(): iterable
    {

    
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-tachometer-alt');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        
        yield MenuItem::linkToCrud('All Users', 'fas fa-users', User::class);

        yield MenuItem::section('Jobs');

        yield MenuItem::linkToCrud('Job Categories', 'fas fa-briefcase', JobCategory::class);
        
        yield MenuItem::section('Candidates');
        
        yield MenuItem::linkToCrud('Candidates', 'fas fa-users', Candidate::class);
        yield MenuItem::linkToCrud('Job applications', 'fas fa-paste', JobApplication::class);
        yield MenuItem::linkToCrud('Genders', 'fas fa-genderless', Gender::class);
        
        yield MenuItem::section('Recruters');

        yield MenuItem::linkToCrud('Clients', 'fas fa-users', Client::class);
        yield MenuItem::linkToCrud('Job Offers', 'fas fa-handshake', JobOffer::class);




    }
}
