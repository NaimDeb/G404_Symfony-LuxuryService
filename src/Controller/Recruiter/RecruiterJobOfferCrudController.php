<?php

namespace App\Controller\Recruiter;

use App\Entity\Client;
use App\Entity\JobOffer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecruiterJobOfferCrudController extends AbstractCrudController
{
    public function __construct(private SluggerInterface $slugger)
    {}

    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        /** @var User */
        $user = $this->getUser();
        /** @var Client  */
        $client = $user->getClient();

        $queryBuilder->andWhere("entity.client = :client")
            ->setParameter('client', $client);

        return $queryBuilder;
    }





    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('client')->hideOnForm(),
            TextField::new('jobTitle', 'Job Title'),
            BooleanField::new('isActive', 'is_active'),
            AssociationField::new('category')->autocomplete(),
            TextField::new('jobType', 'Job Type'),
            TextEditorField::new('description')->setFormType(TextareaType::class),
            TextField::new('location'),
            NumberField::new('salary'),
            DateTimeField::new('createdAt', 'created_at')->setFormTypeOption('disabled', true),
            TextField::new('slug')->hideOnForm(),
        ];
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        /** @var User */
        $user = $this->getUser();
        /** @var Client */
        $client = $user->getClient();


        if ($entityInstance instanceof JobOffer) {
            $entityInstance->setClient($client);
            $entityInstance->setCreatedAt(new DateTimeImmutable());

            

            $this->slugTitle($entityInstance);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }


    private function slugTitle(JobOffer $jobOffer) {

        $sluggifiedTitle = $this->slugger->slug($jobOffer->getJobTitle());

        $jobOffer->setSlug($sluggifiedTitle);

    }


}
