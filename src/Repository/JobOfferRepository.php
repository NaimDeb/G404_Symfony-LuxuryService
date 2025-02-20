<?php

namespace App\Repository;

use App\Entity\JobOffer;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\DTO\JobOfferCardDTO;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<JobOffer>
 */
class JobOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, JobOffer::class);
    }

    // public function paginateJobOffers(int $page, int $limit) {
    //     return $this->paginator->paginate(
    //         $this->getJob

    //     )
    // }
    

    public function getJobOffersWithApplicationStatus(int $numberOfResults, int $paginationPage = 1, ?User $user = null) {


        // Checks if user is logged (else null), gets Candidate (if null, returns null), gets Id
        $candidateId = $user ? ($user->getCandidate()?->getId() ?? null) : null;



        $offset = ($paginationPage - 1) * $numberOfResults;
        
        
        if ($candidateId) {
            // When a candidate is provided, use the CASE expression directly in the constructor.
            $qb = $this->createQueryBuilder('jobOffers')
                ->select('NEW App\\DTO\\JobOfferCardDTO(
                    jobOffers.id,
                    offer.slug as categorySlug,
                    COALESCE(SUBSTRING(jobOffers.description, 1, 100), \'Pas de description\') AS description,
                    jobOffers.jobTitle,
                    jobOffers.location,
                    jobOffers.salary,
                    jobOffers.createdAt,
                    jobOffers.slug,
                    CASE WHEN jobApp.candidate = :candidateId THEN true ELSE false END
                )')
                ->join('jobOffers.category', 'offer')
                ->leftJoin('jobOffers.jobApplications', 'jobApp')
                ->where('jobOffers.isActive = :active')
                ->setParameter('active', true)
                ->setParameter('candidateId', $candidateId)
                ->setMaxResults($numberOfResults)
                ->setFirstResult($offset)
                ->orderBy('jobOffers.createdAt', 'DESC');
        } else {
            // When no candidate is provided, simply set isApplied to false.
            $qb = $this->createQueryBuilder('jobOffers')
                ->select('NEW App\\DTO\\JobOfferCardDTO(
                    jobOffers.id,
                    offer.slug as categorySlug,
                    COALESCE(SUBSTRING(jobOffers.description, 1, 100), \'Pas de description\') AS description,
                    jobOffers.jobTitle,
                    jobOffers.location,
                    jobOffers.salary,
                    jobOffers.createdAt,
                    jobOffers.slug,
                    false
                )')
                ->join('jobOffers.category', 'offer')
                ->where('jobOffers.isActive = :active')
                ->setParameter('active', true)
                ->setMaxResults($numberOfResults)
                ->setFirstResult($offset)
                ->orderBy('jobOffers.createdAt', 'DESC');
        }

        $pagination = $this->paginator->paginate(
            $qb,
            $paginationPage,
            $numberOfResults
        );
    
        return $pagination;



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
