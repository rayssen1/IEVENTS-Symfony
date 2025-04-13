<?php

namespace App\Repository;

use App\Entity\Reponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reponse>
 *
 * @method Reponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reponse[]    findAll()
 * @method Reponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reponse::class);
    }

    /**
     * @return Reponse[] Returns an array of Reponse objects
     */
    public function findByReclamationId($reclamationId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.reclamation = :reclamationId')
            ->setParameter('reclamationId', $reclamationId)
            ->orderBy('r.dateRep', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reponse[] Returns an array of Reponse objects with a specific status (etat)
     */
    public function findByEtat(string $etat): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.etat = :etat')
            ->setParameter('etat', $etat)
            ->orderBy('r.dateRep', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reponse|null Returns a single Reponse object based on reclamation ID and status (etat)
     */
    public function findOneByReclamationAndEtat($reclamationId, string $etat): ?Reponse
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.reclamation = :reclamationId')
            ->andWhere('r.etat = :etat')
            ->setParameter('reclamationId', $reclamationId)
            ->setParameter('etat', $etat)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // You can add more custom methods as needed for your application's requirements.
}
