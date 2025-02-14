<?php

namespace App\Repository;

use App\Entity\JobOffer;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobOffer>
 */
class JobOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobOffer::class);
    }

    public function getLimitedJobOffersCardsWithApplied(int $limit, ?User $user = null) {

        $candidateId = $user->getCandidate()->getId();
        
        $qb = $this->createQueryBuilder('jobOffers')
        
            ->select('offer.category.slug as categorySlug, jobOffers.id, SUBSTRING(jobOffers.description, 1, 100) as description, jobOffers.jobTitle, jobOffers.location, jobOffers.salary, jobOffers.createdAt, jobOffers.slug')
            ->join('jobOffers.category', 'offer')
            ->where('jobOffers.isActive = true')
            ->leftJoin('jobOffers.jobApplications', 'jobApp')
            ->setParameter('limit', $limit)
            ->setMaxResults(':limit');
            
        if ($candidateId) {
            return $qb->addSelect('CASE WHEN jobApp.candidate IS :candidateId THEN true ELSE false END as isApplied')
            ->setParameter('candidateId', $candidateId)
            ->getQuery();
        }

        // Todo : implement

        return $qb->getQuery();



    }

    //    /**
    //     * @return JobOffer[] Returns an array of JobOffer objects
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

    //    public function findOneBySomeField($value): ?JobOffer
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
