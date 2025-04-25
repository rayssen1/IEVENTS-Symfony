<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Evenement;
use App\Entity\Reservation;
use App\Entity\Ticket;
use App\Form\Reservation1Type;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reservation')]
final class ReservationController extends AbstractController
{
    #[Route(name: 'app_reservation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/mes-reservations', name: 'app_reservation_index_current', methods: ['GET'])]
    public function indexForCurrentUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $symfonySession = $request->getSession();
        $id = $symfonySession->get('user_id');
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findBy(['userId' => $id]);

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(Reservation1Type::class, $reservation);

        $symfonySession = $request->getSession();
        $userId = $symfonySession->get('user_id');
        $user = $entityManager->getRepository(User::class)->find($userId);
        $reservation->setUserId($user);

        $eventId = $request->query->get('eventId');
        $event = $entityManager->getRepository(Evenement::class)->find($eventId);
        
        if (!$event) {
            throw $this->createNotFoundException('Événement non trouvé');
        }
        
        $reservation->setEvenement($event);
        $reservation->setCreatedAt(new \DateTime());
        $reservation->setStatus('en attente');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get form data
            $formData = $request->request->all('reservation1');
            $ticketType = $formData['ticketType'];
            $ticketCount = (int)$formData['ticketCount'];
            $totalPrice = (float)$formData['totalPrice'];
            
            // Create ticket
            $ticket = new Ticket();
            $ticket->setReservationId($reservation);
            $ticket->setTicketType($ticketType);
            $ticket->setTicketCount($ticketCount);
            
            // Calculate ticket price based on type
            $basePrice = $event->getPrix();
            $multiplier = match($ticketType) {
                'VIP' => 2.0,
                'BASIC' => 1.0,
                'KID' => 0.5,
                default => 1.0
            };
            
            $ticketPrice = $basePrice * $multiplier;
            $ticket->setPrice($ticketPrice);
            
            // Set total price
            $reservation->setTotalPrice($totalPrice);
            
            // Generate QR code
            $ticket->setQrCode(uniqid('TICKET_', true));

            $entityManager->persist($reservation);
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index_current', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket-details.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'event' => $event,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Reservation1Type::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get form data
            $formData = $request->request->all('reservation1');
            $ticketType = $formData['ticketType'];
            $ticketCount = (int)$formData['ticketCount'];
            $status = $formData['status'];

            // Get the event
            $event = $reservation->getEvenement();
            $basePrice = $event->getPrix();

            // Calculate total price based on ticket type and count
            $multiplier = match($ticketType) {
                'VIP' => 2.0,
                'BASIC' => 1.0,
                'KID' => 0.5,
                default => 1.0
            };
            
            $totalPrice = $basePrice * $ticketCount * $multiplier;
            $reservation->setTotalPrice($totalPrice);

            // Check if the reservation has tickets
            $tickets = $reservation->getTickets();
            $ticket = null;
            
            if ($tickets->isEmpty()) {
                // Create a new ticket if none exists
                $ticket = new Ticket();
                $ticket->setReservationId($reservation);
                $ticket->setQrCode(uniqid('TICKET_', true));
                $entityManager->persist($ticket);
            } else {
                // Use the first existing ticket
                $ticket = $tickets->first();
            }
            
            // Update ticket properties
            $ticket->setTicketType($ticketType);
            $ticket->setTicketCount($ticketCount);
            $ticket->setPrice($basePrice * $multiplier);

            // Update reservation status
            $reservation->setStatus($status);

            $entityManager->flush();

            $this->addFlash('success', 'La réservation a été mise à jour avec succès.');
            return $this->redirectToRoute('app_reservation_index_current', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index_current', [], Response::HTTP_SEE_OTHER);
    }
}
