<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(User::class);
    }

    public function findAll(): array
    {
      //  return $this->repository->findAll();
        return $this->em->findAll();
    }

    public function findById(int $id): ?User
    {
        return $this->repository->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function remove(int $id): void
    {
        $user = $this->findById($id);
        if ($user) {
         
            $user->setState("desactive"); // assuming a setter method for state exists

            // Get the EntityManager
            $this->em->flush();
        } else {
            // Handle the case where the user doesn't exist
            throw new \Exception("User not found");
        }
    }

    // Add more custom queries here if needed
}
