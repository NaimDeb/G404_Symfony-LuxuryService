<?php

namespace App\Controller\Recruiter;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RecruiterUserCrudController extends AbstractCrudController
{

    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Recruiter')
            ->setEntityLabelInPlural('Recruiters')
            ->setPagetitle(Crud::PAGE_INDEX, 'Recruiters')
            ->setPagetitle(Crud::PAGE_EDIT, 'Edit Recruiter')
            ->setPagetitle(Crud::PAGE_NEW, 'New Recruiter');
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        if ($entityInstance instanceof User) {
            $this->hashPassword($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }



    // Override index (filter)
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        /** @var User */
        $user = $this->getUser();

        $queryBuilder->andWhere("entity.id LIKE :id")
            ->setParameter('id', $user->getId());

        return $queryBuilder;
    }

    private function hashPassword(User $user) {
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $user->getPassword()));
    }


    

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('password', 'Password')
                ->setFormType(RepeatedType::class)
                ->setFormTypeOption('type', PasswordType::class)
                ->setFormTypeOption('first_options', ['label' => 'Password'])
                ->setFormTypeOption('second_options', ['label' => '(Repeat)'])
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->onlyOnForms(),
        ];
    }

    
}

