<?php
namespace App\EventSubscriber;

use App\Entity\Candidate;
use App\Entity\JobApplication;
use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    
    
    private SluggerInterface $slugger;
    private EntityManagerInterface $entityManager;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $this->slugger = $slugger;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => [
                ['setJobOfferSlug', 0],
                ['associateJobApplicationWithCandidate', 0]
            ],
        ];
    }


    /**
     * Slugify the name and sets it to the entity
     */
    public function setJobOfferSlug(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof JobOffer)) {
            return;
        }

        $slug = $this->slugger->slug($entity->getJobTitle());
        $entity->setSlug($slug);
    }

    /**
     * Uses the method addJobApplication for the candidate
     */
    public function associateJobApplicationWithCandidate(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof JobApplication)) {
            return;
        }

        $candidate = $entity->getCandidate();
        if (!$candidate instanceof Candidate) {
            return;
        }

        $candidate->addJobApplication($entity);

    }
}


?>