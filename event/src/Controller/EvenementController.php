<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\User; // This should point to your User entity
use App\Form\EvenementType;
use App\Repository\EventspeakerRepository;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/evenement')]
final class EvenementController extends AbstractController
{
    #[Route(name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $repository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em,
    EventspeakerRepository $eventspeakerRepository 
    ): Response
    {
        $evenement = new Evenement();
        
       /* // Get the current user
        $currentUser = $this->getUser();
        // Check if the user is logged in and has the role "organisateur"
        if ($currentUser && $currentUser->getRole() === 'organisateur') {
        $evenement->setOrganisateurId($currentUser);
        } else {
        // Optionally handle the case where the user is not an organisateur
        throw $this->createAccessDeniedException('Seuls les organisateurs peuvent créer des événements.');
        }*/
        $organisateur = $em->getRepository(User::class)->findOneBy(['role' => 'organisateur']);
        
        if (!$organisateur) {
            throw $this->createNotFoundException('No user with role "organisateur" found. Please add one to the database.');
        }
        
        // Set the fetched organisateur as the organisateurId
        $evenement->setOrganisateurId($organisateur);
        // Find the first available Eventspeaker with status "dispo"
        $availableEventspeaker = $eventspeakerRepository->findOneAvailableEventspeaker(); // Use the correct method
        if (!$availableEventspeaker) {
            throw $this->createNotFoundException('No available Eventspeaker found');
        }

        // Set the available Eventspeaker to the Evenement
        $evenement->setEventspeakerId($availableEventspeaker);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(
        '/{id}',
        name: 'app_evenement_show',
        methods: ['GET'],
        requirements: ['id' => Requirement::DIGITS]
    )]
    public function show(int $id, EvenementRepository $repository): Response
    {
        $evenement = $repository->find($id);
        
        if (!$evenement) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route(
        '/{id}/edit',
        name: 'app_evenement_edit',
        methods: ['GET', 'POST'],
        requirements: ['id' => Requirement::DIGITS]
    )]
    public function edit(Request $request, int $id, EvenementRepository $repository, EntityManagerInterface $em): Response
    {
        $evenement = $repository->find($id);
        
        if (!$evenement) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    #[Route(
        '/{id}',
        name: 'app_evenement_delete',
        methods: ['POST'],
        requirements: ['id' => Requirement::DIGITS]
    )]
    public function delete(Request $request, int $id, EvenementRepository $repository, EntityManagerInterface $em): Response
    {
        $evenement = $repository->find($id);
        
        if (!$evenement) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $em->remove($evenement);
            $em->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
