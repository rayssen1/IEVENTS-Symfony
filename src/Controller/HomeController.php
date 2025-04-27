<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EvenementRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();
        
        return $this->render('home.html.twig', [
            'events' => $events,
        ]);
    }
}
