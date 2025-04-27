<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Service\GeminiService;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;

#[Route('/events')]
final class EventFrontController extends AbstractController
{
    private $dompdf;
    private $kernel;

    public function __construct(Dompdf $dompdf, KernelInterface $kernel)
    {
        $this->dompdf = $dompdf;
        $this->kernel = $kernel;
    }

    #[Route(name: 'app_events_index', methods: ['GET'])]
    public function index(Request $request, EvenementRepository $repository, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $repository->createQueryBuilder('e')
            ->where('e.status != :status')
            ->setParameter('status', 'Depassé')
            ->orderBy('e.dateEvent', 'ASC');

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('eventfront/shows-events.html.twig', [
            'pagination' => $pagination,
            'evenements' => $pagination, // <--- add this line
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

        return $this->render('eventfront/shows-events.html.twig', [
            'evenements' => [$evenement],
            'is_single' => true
        ]);
    }

    #[Route(
        '/{id}/pdf',
        name: 'app_evenement_pdf',
        methods: ['GET'],
        requirements: ['id' => Requirement::DIGITS]
    )]
    public function pdf(int $id, EvenementRepository $repository): Response
    {
        $evenement = $repository->find($id);
        
        if (!$evenement) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        $html = $this->renderView('eventfront/pdf.html.twig', [
            'evenement' => $evenement,
            'project_dir' => $this->kernel->getProjectDir(),
        ]);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $output = $this->dompdf->output();

        return new Response(
            $output,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="fiche-evenement-' . str_replace(' ', '-', $evenement->getTitre()) . '.pdf"',
            ]
        );
    }

    #[Route(
        '/chat',
        name: 'app_gemini_chat',
        methods: ['GET', 'POST']
    )]
    public function chat(Request $request, GeminiService $geminiService): Response
    {
        $chatHistory = $request->getSession()->get('chat_history', []);
        $response = '';

        if ($request->isMethod('POST')) {
            $userMessage = $request->request->get('message');
            if ($userMessage) {
                $response = $geminiService->getChatResponse($userMessage);
                $chatHistory[] = ['user' => $userMessage, 'bot' => $response];
                $request->getSession()->set('chat_history', $chatHistory);
            }
        }

        return $this->render('eventfront/gemini_chat.html.twig', [
            'chat_history' => $chatHistory,
            'response' => $response,
        ]);
    }
}