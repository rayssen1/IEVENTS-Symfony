<?php
namespace App\Repository;

use App\Entity\Equipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipment::class);
    }

// src/Repository/EquipmentRepository.php

public function findByFilters(?string $name, ?string $type, ?string $status): array
{
    $qb = $this->createQueryBuilder('e');

    if ($name) {
        $qb->andWhere('LOWER(e.name) LIKE :name')
           ->setParameter('name', '%' . strtolower($name) . '%');
    }

    if ($type) {
        $qb->andWhere('LOWER(e.type) LIKE :type')
           ->setParameter('type', '%' . strtolower($type) . '%');
    }

    if ($status) {
        $qb->andWhere('LOWER(e.status) LIKE :status')
           ->setParameter('status', '%' . strtolower($status) . '%');
    }

    return $qb->orderBy('e.name', 'ASC')
              ->getQuery()
              ->getResult();
}
public function findLowStockEquipments(int $threshold = 50): array
{
    return $this->createQueryBuilder('e')
        ->where('e.quantity < :threshold')
        ->setParameter('threshold', $threshold)
        ->getQuery()
        ->getResult();
}

}