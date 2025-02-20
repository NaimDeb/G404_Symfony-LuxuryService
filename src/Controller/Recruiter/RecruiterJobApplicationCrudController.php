<?php

namespace App\Controller\Recruiter;

use App\Entity\JobApplication;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class RecruiterJobApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobApplication::class;
    }

    public function configureActions(Actions $actions): Actions
{
    return $actions
        // ...
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->remove(Crud::PAGE_INDEX, Action::NEW)
        ->remove(Crud::PAGE_DETAIL, Action::EDIT)
    ;
}

// Todo : only applications for user


    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        /** @var User */
        $user = $this->getUser();
        /** @var Client  */
        $client = $user->getClient();

        $queryBuilder
            ->innerJoin('entity.jobOffer', 'jobOffer')
            ->innerJoin('entity.candidate', 'candidate')
            ->andWhere("jobOffer.client = :client")
            ->setParameter('client', $client);

        return $queryBuilder;
    }


    public function configureFields(string $pageName): iterable
    {


        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            return [
                IdField::new('id')->hideOnForm(),
                TextField::new('candidate.lastName', 'Nom du candidat'),
                TextField::new('candidate.firstName', 'Nom du candidat'),
                TextField::new('jobOffer.jobTitle', 'Titre du job'),
                NumberField::new('jobOffer.salary', 'Salaire proposé'),
                TextField::new('jobOffer.jobCategory', 'La catégorie de l\'offre d\'emploi'),
                TextField::new('status', 'Statut'),
            ];
        } 

        return [];
    }




    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
