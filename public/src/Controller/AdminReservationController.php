<?php

namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminReservationController extends AbstractController
{
    #[Route('/reservations', name: 'admin_reservation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager->getRepository(Reservation::class)->findAll();

        $totalReservations = count($reservations);
        $confirmedReservations = 0;

        foreach ($reservations as $reservation) {
            if ($reservation->getStatus() === 'confirmee') {
                $confirmedReservations++;
            }
        }

        $confirmationRate = $totalReservations > 0 ? ($confirmedReservations / $totalReservations) * 100 : 0;

        return $this->render('admin/reservations.html.twig', [
            'reservations' => $reservations,
            'confirmationRate' => $confirmationRate,
            'totalReservations' => $totalReservations,
            'confirmedReservations' => $confirmedReservations,
        ]);
    }
}
