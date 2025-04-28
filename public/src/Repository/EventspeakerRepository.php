<?php

namespace App\Repository;

use App\Entity\Eventspeaker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Eventspeaker>
 */
class EventspeakerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eventspeaker::class);
    }

    /**
     * Find all Eventspeakers with status 'dispo', sorted by name.
     *
     * @return Eventspeaker[]
     */
    public function findAvailableEventspeakers(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->setParameter('status', 'dispo')
            ->orderBy('e.nom', 'ASC') // Sort by last name
            ->addOrderBy('e.prenom', 'ASC') // Then first name
            ->getQuery()
            ->getResult();
    }

    /**
     * Find one Eventspeaker with status 'dispo', sorted by name.
     *
     * @return Eventspeaker|null
     */
    public function findOneAvailableEventspeaker(): ?Eventspeaker
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->setParameter('status', 'dispo')
            ->orderBy('e.nom', 'ASC')
            ->addOrderBy('e.prenom', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}