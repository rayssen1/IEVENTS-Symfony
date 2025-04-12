<?php

namespace App\Controller;
use App\Entity\Equipment;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/equipmentFront')]
final class EquipmentFrontController extends AbstractController
{
    
    #[Route( name: 'equipmentF_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $equipments = $entityManager->getRepository(Equipment::class)->findAll();

        return $this->render('equipmentFront/ShowEquipment.html.twig', [
            'equipments' => $equipments,
            'is_single' => false
        ]);
    }
    
    }


