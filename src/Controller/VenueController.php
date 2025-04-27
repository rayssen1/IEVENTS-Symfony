<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/venue')]
final class VenueController extends AbstractController
{
    #[Route('/rent', name: 'app_venue_rent', methods: ['GET'])]
    public function rent(): Response
    {
        return $this->render('rent-venue.html.twig');
    }
} 