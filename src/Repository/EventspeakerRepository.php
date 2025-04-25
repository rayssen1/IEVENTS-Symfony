<?php

namespace App\Repository;

use App\Entity\Eventspeaker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Eventspeaker>
 *
 * @method Eventspeaker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Eventspeaker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Eventspeaker[]    findAll()
 * @method Eventspeaker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventspeakerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eventspeaker::class);
    }

    /**
     * Find all Eventspeakers with status 'dispo'
     * 
     * @return Eventspeaker[]
     */
    public function findAvailableEventspeakers(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->setParameter('status', 'dispo')
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find one Eventspeaker with status 'dispo'
     * 
     * @return Eventspeaker|null
     */
    public function findOneAvailableEventspeaker(): ?Eventspeaker
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->setParameter('status', 'dispo')
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}