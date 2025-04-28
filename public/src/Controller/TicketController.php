<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/tickets')]
final class TicketController extends AbstractController
{
    #[Route(name: 'app_tickets_index', methods: ['GET'])]
    public function index(TicketRepository $repository): Response
    {
        return $this->render('tickets.html.twig', [
            'tickets' => $repository->findAll(),
        ]);
    }

    #[Route(
        '/{id}',
        name: 'app_tickets_show',
        methods: ['GET'],
        requirements: ['id' => Requirement::DIGITS]
    )]
    public function show(int $id, TicketRepository $repository): Response
    {
        $ticket = $repository->find($id);
        
        if (!$ticket) {
            throw $this->createNotFoundException('Ticket not found');
        }

        return $this->render('ticket-details.html.twig', [
            'ticket' => $ticket,
        ]);
    }
} 