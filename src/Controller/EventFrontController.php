<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/events')]
final class EventFrontController extends AbstractController
{
    #[Route(name: 'app_events_index', methods: ['GET'])]
    public function index(EvenementRepository $repository): Response
    {
        return $this->render('eventfront/showevent.html.twig', [
            'evenements' => $repository->findAll(),
            'is_single' => false
        ]);
    }

    #[Route(
        '/{id}',
        name: 'app_events_show',
        methods: ['GET'],
        requirements: ['id' => Requirement::DIGITS]
    )]
    public function show(int $id, EvenementRepository $repository): Response
    {
        $evenement = $repository->find($id);
        
        if (!$evenement) {
            throw $this->createNotFoundException('Event not found');
        }

        return $this->render('eventfront/showevent.html.twig', [
            'evenements' => [$evenement],
            'is_single' => true
        ]);
    }
}