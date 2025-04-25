<?php
<<<<<<< HEAD
=======
//src/Controller/EquipmentFrontController;
>>>>>>> 4dbb084 (code barre eq)

namespace App\Controller;
use App\Entity\Equipment;
use Doctrine\ORM\EntityManagerInterface;
<<<<<<< HEAD

use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
=======
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
>>>>>>> 4dbb084 (code barre eq)

#[Route('/equipmentFront')]
final class EquipmentFrontController extends AbstractController
{
<<<<<<< HEAD
    
    #[Route( name: 'equipmentF_index', methods: ['GET'])]
=======
    #[Route('/', name: 'equipmentF_index', methods: ['GET'])]
>>>>>>> 4dbb084 (code barre eq)
    public function index(EntityManagerInterface $entityManager): Response
    {
        $equipments = $entityManager->getRepository(Equipment::class)->findAll();

        return $this->render('equipmentFront/ShowEquipment.html.twig', [
            'equipments' => $equipments,
<<<<<<< HEAD
            'is_single' => false
        ]);
    }
    
    }


=======
            'is_single' => false,
        ]);
    }
}
>>>>>>> 4dbb084 (code barre eq)
