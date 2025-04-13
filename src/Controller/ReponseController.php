<?php
// src/Controller/ReponseController.php
namespace App\Controller;

use App\Entity\Reponse;
use App\Form\ReponseType;
use App\Repository\ReponseRepository;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reponse')]
class ReponseController extends AbstractController
{
    // Afficher la liste des réponses et des réclamations
    #[Route('/', name: 'reponse_index', methods: ['GET'])]
    public function index(
        ReponseRepository $reponseRepository,
        ReclamationRepository $reclamationRepository
    ): Response {
        return $this->render('reponse/index.html.twig', [
            'reponses' => $reponseRepository->findAll(),
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    // Créer une nouvelle réponse
    #[Route('/new', name: 'reponse_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository, EntityManagerInterface $em): Response
    {
        $reponse = new Reponse();
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $reclamation = $reclamationRepository->findOneBy(['email' => $email]);

            if (!$reclamation) {
                $this->addFlash('error', 'Aucune réclamation trouvée avec cet email.');
            } else {
                $reponse->setReclamation($reclamation);
                $reponse->setMessageRec($reclamation->getSubject());

                $em->persist($reponse);
                $em->flush();

                $this->addFlash('success', 'Réponse ajoutée.');
                return $this->redirectToRoute('reponse_index');
            }
        }

        return $this->render('reponse/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Afficher une réponse spécifique
    #[Route('/{id}', name: 'reponse_show', methods: ['GET'])]
    public function show(Reponse $reponse): Response
    {
        return $this->render('reponse/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }

    // Modifier une réponse existante
    #[Route('/{id}/edit', name: 'reponse_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reponse $reponse, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $reclamation = $em->getRepository(\App\Entity\Reclamation::class)->findOneBy(['email' => $email]);

            if ($reclamation) {
                $reponse->setReclamation($reclamation);
                $reponse->setMessageRec($reclamation->getSubject());
            }

            $em->flush();
            $this->addFlash('success', 'Réponse mise à jour.');
            return $this->redirectToRoute('reponse_index');
        }

        return $this->render('reponse/edit.html.twig', [
            'form' => $form->createView(),
            'reponse' => $reponse,
        ]);
    }

    // Supprimer une réponse
    #[Route('/{id}', name: 'reponse_delete', methods: ['POST'])]
    public function delete(Request $request, Reponse $reponse, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reponse->getId(), $request->request->get('_token'))) {
            $em->remove($reponse);
            $em->flush();
            $this->addFlash('success', 'Réponse supprimée.');
        }

        return $this->redirectToRoute('reponse_index');
    }
}
