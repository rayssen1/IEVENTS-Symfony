<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\User;
use App\Form\EvenementType;
use App\Repository\EventspeakerRepository;
use App\Repository\EvenementRepository;
use App\Service\GoogleCalendarService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/evenement')]
final class EvenementController extends AbstractController
{
    private GoogleCalendarService $googleCalendarService;

    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        $this->googleCalendarService = $googleCalendarService;
    }

    #[Route(name: 'app_evenement_index', methods: ['GET'])]
    public function index(Request $request, EvenementRepository $repository, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $repository->createQueryBuilder('e');

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            2
        );

        $eventsByLocation = $repository->getEventsByLocation();
        $eventsByMonth = $repository->getEventsByMonth();

        return $this->render('evenement/index.html.twig', [
            'pagination' => $pagination,
            'eventsByLocation' => $eventsByLocation,
            'eventsByMonth' => $eventsByMonth,
        ]);
    }

    #[Route('/search', name: 'app_evenement_search', methods: ['POST'])]
    public function search(Request $request, EvenementRepository $repository, PaginatorInterface $paginator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $search = $data['search'] ?? '';
        $sort = $data['sort'] ?? '';
        $page = $data['page'] ?? 1;

        $queryBuilder = $repository->createQueryBuilder('e');

        if ($search) {
            $queryBuilder
                ->where('LOWER(e.titre) LIKE :search')
                ->orWhere('LOWER(e.description) LIKE :search')
                ->setParameter('search', '%' . strtolower($search) . '%');
        }

        if ($sort === 'asc') {
            $queryBuilder->orderBy('e.prix', 'ASC');
        } elseif ($sort === 'desc') {
            $queryBuilder->orderBy('e.prix', 'DESC');
        }

        $pagination = $paginator->paginate(
            $queryBuilder,
            $page,
            2
        );

        $html = $this->renderView('evenement/_event_list.html.twig', [
            'pagination' => $pagination,
        ]);

        return new JsonResponse(['html' => $html]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, EventspeakerRepository $eventspeakerRepository, SessionInterface $session): Response
    {
        $evenement = new Evenement();
        
        $userId = $session->get('user_id');
        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour créer un événement.');
        }

        $currentUser = $em->getRepository(User::class)->find($userId);
        if (!$currentUser || $currentUser->getRole() !== 'organisateur') {
            throw $this->createAccessDeniedException('Seuls les organisateurs peuvent créer des événements.');
        }
        
        $evenement->setOrganisateurId($currentUser);

        $defaultSpeaker = $eventspeakerRepository->findOneBy(['status' => 'dispo']);
        if (!$defaultSpeaker) {
            throw new \RuntimeException('Aucun conférencier disponible trouvé.');
        }
        $evenement->setEventspeakerId($defaultSpeaker);

        $currentSpeakerId = $defaultSpeaker->getId();
        $form = $this->createForm(EvenementType::class, $evenement, [
            'currentSpeakerId' => $currentSpeakerId,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedSpeaker = $evenement->getEventspeakerId();
            if ($selectedSpeaker && $selectedSpeaker !== $defaultSpeaker) {
                $selectedSpeaker->setStatus('non dispo');
                $em->persist($selectedSpeaker);
            }

            $imageFile = $form->get('img')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $evenement->setImg($newFilename);
            }

            $em->persist($evenement);
            $em->flush();

            $syncWithGoogle = $form->get('syncWithGoogle')->getData();
            if ($syncWithGoogle) {
                if ($this->googleCalendarService->hasValidAccessToken()) {
                    $success = $this->googleCalendarService->createEvent($evenement);
                    if ($success) {
                        $this->addFlash('success', 'Événement créé et synchronisé avec Google Calendar !');
                    } else {
                        $this->addFlash('error', 'Erreur lors de la synchronisation avec Google Calendar.');
                    }
                } else {
                    $this->addFlash('warning', 'Vous n\'êtes pas connecté à Google Calendar. Veuillez vous connecter avant de synchroniser.');
                }
            }

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
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

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Request $request, int $id, EvenementRepository $repository, EntityManagerInterface $em, EventspeakerRepository $eventspeakerRepository): Response
    {
        $evenement = $repository->find($id);
        
        if (!$evenement) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        $oldSpeaker = $evenement->getEventspeakerId();
        $currentSpeakerId = $oldSpeaker ? $oldSpeaker->getId() : null;
        $form = $this->createForm(EvenementType::class, $evenement, [
            'currentSpeakerId' => $currentSpeakerId,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedSpeaker = $evenement->getEventspeakerId();
            if ($selectedSpeaker && $selectedSpeaker !== $oldSpeaker) {
                $selectedSpeaker->setStatus('non dispo');
                $em->persist($selectedSpeaker);
                if ($oldSpeaker) {
                    $oldSpeaker->setStatus('dispo');
                    $em->persist($oldSpeaker);
                }
            }

            $imageFile = $form->get('img')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $evenement->setImg($newFilename);
            }

            $em->flush();

            $syncWithGoogle = $form->get('syncWithGoogle')->getData();
            if ($syncWithGoogle) {
                if ($this->googleCalendarService->hasValidAccessToken()) {
                    $success = $this->googleCalendarService->createEvent($evenement);
                    if ($success) {
                        $this->addFlash('success', 'Événement créé et synchronisé avec Google Calendar !');
                    } else {
                        $this->addFlash('error', 'Erreur lors de la synchronisation avec Google Calendar.');
                    }
                } else {
                    $this->addFlash('warning', 'Vous n\'êtes pas connecté à Google Calendar. Veuillez vous connecter avant de synchroniser.');
                }
            }

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'], requirements: ['id' => Requirement::DIGITS])]
    public function delete(Request $request, int $id, EvenementRepository $repository, EntityManagerInterface $em): Response
    {
        $evenement = $repository->find($id);
        
        if (!$evenement) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $eventspeaker = $evenement->getEventspeakerId();
            if ($eventspeaker) {
                $eventspeaker->setStatus('dispo');
                $em->persist($eventspeaker);
            }
            $em->remove($evenement);
            $em->flush();
            $this->addFlash('success', 'Événement supprimé avec succès.');
        }

        return $this->redirectToRoute('evenement_calendar', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/google-auth', name: 'evenement_google_auth', methods: ['GET'])]
    public function googleAuth(): Response
    {
        return $this->redirect($this->googleCalendarService->getAuthUrl());
    }

    #[Route('/google-callback', name: 'evenement_google_callback', methods: ['GET'])]
    public function googleCallback(Request $request, SessionInterface $session): Response
    {
        $code = $request->query->get('code');
        if ($code) {
            $this->googleCalendarService->handleCallback($code);
            $this->addFlash('success', 'Compte Google connecté avec succès !');
        } else {
            $this->addFlash('error', 'Échec de la connexion à Google Calendar.');
        }

        return $this->redirectToRoute('evenement_calendar');
    }

    #[Route('/calendar', name: 'evenement_calendar', methods: ['GET'])]
    public function calendar(): Response
    {
        $isGoogleConnected = $this->googleCalendarService->hasValidAccessToken();

        // Définir une plage de dates pour récupérer les événements (par exemple, 1 an avant et après aujourd'hui)
        $startDate = new \DateTime('now -1 year');
        $endDate = new \DateTime('now +1 year');

        // Récupérer les événements depuis Google Calendar
        $events = $this->googleCalendarService->getEvents($startDate, $endDate);

        return $this->render('evenement/calendar.html.twig', [
            'google_auth_url' => $this->googleCalendarService->getAuthUrl(),
            'is_google_connected' => $isGoogleConnected,
            'events' => $events,
        ]);
    }
    
    #[Route('/google-clear-token', name: 'evenement_google_clear_token', methods: ['GET'])]
    public function clearGoogleToken(): Response
    {
        $this->googleCalendarService->clearAccessToken();
        $this->addFlash('success', 'Token Google Calendar supprimé.');
        return $this->redirectToRoute('app_evenement_index');
    }

    #[Route('/delete-google-event/{id}', name: 'app_evenement_delete_google_event', methods: ['POST'])]
    public function deleteGoogleEventAjax(Request $request, string $id): JsonResponse
    {
        // Vérifier le jeton CSRF
        if (!$this->isCsrfTokenValid('delete_google_event', $request->request->get('_token'))) {
            return new JsonResponse(['success' => false, 'message' => 'Jeton CSRF invalide'], 403);
        }

        if (!$this->googleCalendarService->hasValidAccessToken()) {
            return new JsonResponse(['success' => false, 'message' => 'Non connecté à Google Calendar'], 401);
        }

        try {
            $success = $this->googleCalendarService->deleteEvent($id);
            if ($success) {
                return new JsonResponse(['success' => true, 'message' => 'Événement supprimé avec succès']);
            } else {
                return new JsonResponse(['success' => false, 'message' => 'Erreur lors de la suppression de l\'événement'], 500);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }
}