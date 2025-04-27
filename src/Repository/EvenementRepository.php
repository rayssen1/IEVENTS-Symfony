<?php
namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }
    
    /**
     * Récupère le nombre d'événements par lieu.
     *
     * @return array
     */
    public function getEventsByLocation(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.lieu as lieu, COUNT(e.id) as count')
            ->groupBy('e.lieu')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère le nombre d'événements par mois.
     *
     * @return array
     */
    public function getEventsByMonth(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT DATE_FORMAT(dateEvent, \'%Y-%m\') as month, COUNT(id) as count
            FROM evenement
            WHERE dateEvent IS NOT NULL
            GROUP BY month
            ORDER BY month ASC
        ';
        $stmt = $conn->executeQuery($sql);
        return $stmt->fetchAllAssociative();
    }
}