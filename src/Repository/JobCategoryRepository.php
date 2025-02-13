<?php

namespace App\Repository;

use App\Entity\JobCategory;
use App\Entity\JobOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\DTO\JobOfferLinkDTO;

/**
 * @extends ServiceEntityRepository<JobCategory>
 */
class JobCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobCategory::class);
    }


    /**

     * Finds the adjacent job offers in the same category as the given offer.
     *
     * @param JobOffer $offer The current job offer.
     * 
     * @return array|null An array containing the previous and next job offers, or null if not found.
     */
    public function findAdjacentOffers(JobOffer $offer): ?array
    {
        $qb = $this->createQueryBuilder('jobCategory')
            // JOIN job_offer (ON est fait automatiquement par Doctrine)
            ->join('jobCategory.jobOffers', 'jobOffer')
            // On récupère seulement l'id et le slug
            // SELECT jobOffer.id, jobOffer.slug FROM jobOffer
            // Le NEW DTO créera une entité JobOfferLinkDTO à la fin.
            ->select('NEW App\\DTO\\JobOfferLinkDTO(jobOffer.id, jobOffer.slug)')
            // On récupère seulement les offres de la même catégorie
            // WHERE job.category.id = Id de la catégorie de l'offre en cours
            ->where('jobCategory.id = :categoryId')
            ->setParameter('categoryId', $offer->getCategory()->getId())
            // On récupère les offres qui ne sont pas à la même date que l'offre en cours
            ->andWhere('jobOffer.createdAt != :currentOfferDate')
            ->setParameter('currentOfferDate', $offer->getCreatedAt())
            // On ordonne les offres par date de création ASC
            // ORDER BY jobOffer.createdAt ASC
            ->orderBy('jobOffer.createdAt', 'ASC');

        // On clone le querybuilder  
        $previousOfferQb = clone $qb;
        // On récupère l'offre précédente
        $previousOffer = $previousOfferQb->andWhere('jobOffer.createdAt < :currentOfferDate')
            ->setMaxResults(1)
            ->getQuery()
            // Si on a aucun résultat, donne Null
            ->getOneOrNullResult();

        // On récupère l'offre suivante
        $nextOfferQb = clone $qb;
        $nextOffer = $nextOfferQb->andWhere('jobOffer.createdAt > :currentOfferDate')
            ->setMaxResults(1)
            ->getQuery()
            // Si on a aucun résultat, donne Null
            ->getOneOrNullResult();

        return [
            "previous" => $previousOffer,
            "next" => $nextOffer
        ];
    }






    //    /**
    //     * @return JobCategory[] Returns an array of JobCategory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('j.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?JobCategory
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
