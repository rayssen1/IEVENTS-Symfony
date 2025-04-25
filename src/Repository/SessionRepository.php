<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    // Example custom method: find active sessions by user ID
    public function findActiveSessionsByUser(string $userId): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.user_id = :userId')
            ->andWhere('s.is_active = true')
            ->setParameter('userId', $userId)
            ->orderBy('s.login_time', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
    public function findById(int $id): ?Session
    {
        return $this->repository->find($id);
    }
    public function save(Session $session): void
    {
        $this->em->persist($sessionr);
        $this->em->flush();
    }

    public function remove(Session $session): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }
    // You can add more custom queries as needed
}
