<?php

namespace App\Repository;

use App\Entity\JobOffer;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\DTO\JobOfferCardDTO;

/**
 * @extends ServiceEntityRepository<JobOffer>
 */
class JobOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobOffer::class);
    }

    public function getJobOffersWithApplicationStatus(int $numberOfResults, int $paginationPage = 1, ?User $user = null) {

        if ($user !== null) {
            $candidateId = $user->getCandidate()->getId();
        } else 
        { $candidateId = null; }

        $offset = ($paginationPage - 1) * $numberOfResults;
        
        
        $qb = $this->createQueryBuilder('jobOffers')
            ->select('NEW App\\DTO\\JobOfferCardDTO(
                jobOffers.id,
                offer.slug as categorySlug,
                COALESCE(SUBSTRING(jobOffers.description, 1, 100), \'Pas de description\') AS description,
                jobOffers.jobTitle,
                jobOffers.location,
                jobOffers.salary,
                jobOffers.createdAt,
                jobOffers.slug
            )')
            ->join('jobOffers.category', 'offer')
            ->where('jobOffers.isActive = :active')
            ->setParameter('active', true)
            ->setMaxResults($numberOfResults)
            ->setFirstResult($offset)
            ->orderBy('jobOffers.createdAt' , 'DESC')
            ;
            
            // Not here, since it doesn't get anything even when you're logged out
            if ($candidateId) {
                return $qb
            ->leftJoin('jobOffers.jobApplications', 'jobApp')
            ->addSelect('CASE WHEN jobApp.candidate IS :candidateId THEN true ELSE false END as isApplied')
            ->setParameter('candidateId', $candidateId)
            ->getQuery()
            ->getResult();
            }


        return $qb->getQuery()->getResult(  );



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
