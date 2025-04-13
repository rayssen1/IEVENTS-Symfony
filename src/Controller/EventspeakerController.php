<?php

namespace App\Controller;

use App\Entity\Eventspeaker;
use App\Form\EventspeakerType;
use App\Repository\EventspeakerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/eventspeaker')]
final class EventspeakerController extends AbstractController
{
    #[Route(name: 'app_eventspeaker_index', methods: ['GET'])]
    public function index(EventspeakerRepository $eventspeakerRepository): Response
    {
        $eventspeakers = $eventspeakerRepository->findAll();

        return $this->render('eventspeaker/index.html.twig', [
            'eventspeakers' => $eventspeakers,
        ]);
    }

    #[Route('/new', name: 'app_eventspeaker_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventspeaker = new Eventspeaker();
        $form = $this->createForm(EventspeakerType::class, $eventspeaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventspeaker);
            $entityManager->flush();

            return $this->redirectToRoute('app_eventspeaker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eventspeaker/new.html.twig', [
            'eventspeaker' => $eventspeaker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eventspeaker_show', methods: ['GET'])]
    public function show(Eventspeaker $eventspeaker): Response
    {
        return $this->render('eventspeaker/show.html.twig', [
            'eventspeaker' => $eventspeaker,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_eventspeaker_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Eventspeaker $eventspeaker, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventspeakerType::class, $eventspeaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_eventspeaker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eventspeaker/edit.html.twig', [
            'eventspeaker' => $eventspeaker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eventspeaker_delete', methods: ['POST'])]
    public function delete(Request $request, Eventspeaker $eventspeaker, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventspeaker->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($eventspeaker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_eventspeaker_index', [], Response::HTTP_SEE_OTHER);
    }
}