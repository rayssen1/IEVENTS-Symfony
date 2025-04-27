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
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Service\QrCodeService;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevel;

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

   
    foreach ($reservations as $reservation) {
        try {
            $event = $reservation->getEvenement();
            if (!$event) {
                $reservation->setStatus('annulee');
                $reservation->setEvenement(null);
            }
        } catch (\Doctrine\ORM\EntityNotFoundException $e) {
            $reservation->setStatus('annulee');
           $reservation->setEvenement(null);
        }
    }

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
    if (!$user) {
        throw $this->createNotFoundException('Utilisateur non trouvé');
    }
    $reservation->setUserId($user);

    $eventId = $request->query->get('eventId');
    $event = $entityManager->getRepository(Evenement::class)->find($eventId);
    if (!$event) {
        throw $this->createNotFoundException('Événement non trouvé');
    }

    $reservation->setEvenement($event);
    $reservation->setCreatedAt(new \DateTime());

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $reservation = $form->getData();

        // Get form data
        $ticketType = $form->get('ticketType')->getData();
        $ticketCount = (int)$form->get('ticketCount')->getData();

        // Calculate ticket price and total price
        $basePrice = $event->getPrix();
        $multiplier = match($ticketType) {
            'VIP' => 2.0,
            'BASIC' => 1.0,
            'KID' => 0.5,
            default => 1.0
        };

        $ticketPrice = $basePrice * $multiplier; // Price per ticket
        $totalPrice = $ticketPrice * $ticketCount; // Total for all tickets

        // Create and configure the ticket
        $ticket = new Ticket();
        $ticket->setReservationId($reservation);
        $ticket->setTicketType($ticketType);
        $ticket->setTicketCount($ticketCount);
        $ticket->setPrice($ticketPrice);

        // Set total price for the reservation
        $reservation->setTotalPrice($totalPrice);
        $ticket->setQrCode(uniqid('TICKET_', true));

        // Set default status if not provided
        if (!$reservation->getStatus()) {
            $reservation->setStatus('en attente');
        }

        // Debug total price and status
        $this->addFlash('info', sprintf(
            'Statut: %s, Total Price: %.2f, Ticket Count: %d, Ticket Type: %s',
            $reservation->getStatus(),
            $totalPrice,
            $ticketCount,
            $ticketType
        ));

        $entityManager->persist($reservation);
        $entityManager->persist($ticket);
        $entityManager->flush();

      
        if ($reservation->getStatus() === 'confirmee') {
            return $this->redirectToRoute('app_reservation_pay', [
                'id' => $reservation->getId()
            ]);
        }

        return $this->redirectToRoute('app_reservation_index_current');
    }

    return $this->render('ticket-details.html.twig', [
        'reservation' => $reservation,
        'form' => $form,
        'event' => $event,
    ]);
}


    #[Route('/user/current', name: 'app_reservation_show_current', methods: ['GET'])]
public function showCurrentUserReservations(Request $request, EntityManagerInterface $entityManager): Response
{
    $symfonySession = $request->getSession();
    $userId = $symfonySession->get('user_id');

    if (!$userId) {
        // Si l'utilisateur n'est pas connecté
        return $this->redirectToRoute('app_login'); // ou ta route de login
    }

    $user = $entityManager->getRepository(User::class)->find($userId);

    if (!$user) {
        throw $this->createNotFoundException('Utilisateur non trouvé.');
    }

    $reservations = $entityManager->getRepository(Reservation::class)
        ->findBy(['userId' => $user]);

    return $this->render('reservation/show.html.twig', [
        'reservations' => $reservations,
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
            'event' => $reservation->getEvenement(),
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
    #[Route('/reservation/{id}/pay', name: 'app_reservation_pay', methods: ['GET'])]
public function pay(Reservation $reservation): Response
{
    
    // 1. Get your secret key properly
    $stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'];

    // 2. SET the API key
    \Stripe\Stripe::setApiKey($stripeSecretKey);

    // 3. Create the Stripe session
    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $reservation->getEvenement() ? $reservation->getEvenement()->getTitre() : 'Reservation',
                ],
                'unit_amount' => (int)($reservation->getTotalPrice() * 100),
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $this->generateUrl('app_payment_success', [
        'id' => $reservation->getId()
    ], UrlGeneratorInterface::ABSOLUTE_URL),
    'cancel_url' => $this->generateUrl('app_payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
    ]);

    // 4. Redirect to the Stripe checkout
    return $this->redirect($session->url, 303);
}
#[Route('/payment-success/{id}', name: 'app_payment_success')]
public function success(int $id, EntityManagerInterface $entityManager): Response
{
    // Find the reservation
    $reservation = $entityManager->getRepository(Reservation::class)->find($id);

    if (!$reservation) {
        throw $this->createNotFoundException('Reservation not found.');
    }

    // Update the reservation status to "confirmée"
    $reservation->setStatus('confirmee');
    $entityManager->flush();

    $this->addFlash('success', 'Payment successful! Your reservation is confirmed.');
    return $this->redirectToRoute('app_reservation_index_current');
}

#[Route('/payment-cancel', name: 'app_payment_cancel')]
public function cancel(): Response
{
    $this->addFlash('error', 'Payment cancelled.');
    return $this->redirectToRoute('app_reservation_index_current');
}
#[Route('/reservation/{id}/print', name: 'app_reservation_print', methods: ['GET'])]
public function print(Reservation $reservation): Response
{
    return $this->render('reservation/print.html.twig', [
        'reservation' => $reservation,
    ]);
}


#[Route('/reservation/{id}/ticket', name: 'app_reservation_ticket', methods: ['GET'])]
public function ticket(Reservation $reservation): Response
{
    $data = sprintf(
        "Réservation: %s\nDate: %s\nLieu: %s\nPrix: %.2f DT\nStatut: %s",
        $reservation->getEvenement() ? $reservation->getEvenement()->getTitre() : 'Événement supprimé',
        $reservation->getEvenement() ? $reservation->getEvenement()->getDateEvent()->format('d/m/Y') : 'Date inconnue',
        $reservation->getEvenement() ? $reservation->getEvenement()->getLieu() : 'Lieu inconnu',
        $reservation->getTotalPrice(),
        ucfirst($reservation->getStatus())
    );

    // ➡️ Créer le QrCode
    $qrCode = new QrCode($data);
    $qrCode->setSize(300);
    $qrCode->setMargin(10);

    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // ➡️ Générer l'image encodée en base64 pour Twig
    $qrCodeDataUri = $result->getDataUri();

    return $this->render('reservation/print.html.twig', [
        'reservation' => $reservation,
        'qrCode' => $qrCodeDataUri,
    ]);
}



}


