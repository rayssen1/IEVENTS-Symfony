<?php
namespace App\Repository;

use App\Entity\Equipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

<<<<<<< HEAD
class EvenementRepository extends ServiceEntityRepository
=======
class EquipmentRepository extends ServiceEntityRepository
>>>>>>> 4dbb084 (code barre eq)
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipment::class);
    }
}