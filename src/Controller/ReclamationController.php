<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\EvenementRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    private $validator;

    // Injecting ValidatorInterface into the controller
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    #[Route('/new', name: 'reclamation_new', methods: ['GET', 'POST'])]
public function new(
    Request $request,
    EntityManagerInterface $em,
    UserRepository $userRepository,
    ReclamationRepository $reclamationRepository
): Response {
    $reclamation = new Reclamation();
    $form = $this->createForm(ReclamationType::class, $reclamation);
    $form->handleRequest($request);

    $existingReclamation = null;

    if ($form->isSubmitted()) {
        if ($form->isValid()) {
            $email = $form->get('email')->getData();

            // Validate email format manually
            $emailConstraint = new Email();
            $emailConstraint->message = 'L\'email que vous avez fourni n\'est pas valide.';
            $errors = $this->validator->validate($email, $emailConstraint);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
                return $this->redirectToRoute('reclamation_new');
            }

            // Check if a reclamation already exists for this email
            $existingReclamation = $reclamationRepository->findOneBy(['email' => $email]);

            // Find user by email
            $user = $userRepository->findOneBy(['email' => $email]);
            if (!$user) {
                $this->addFlash('error', 'Utilisateur introuvable avec cet email');
                return $this->redirectToRoute('reclamation_new');
            }

            // Use existing reclamation if exists
            if ($existingReclamation) {
                $reclamation = $existingReclamation;
            }

            // Set reclamation details
            $reclamation->setIdUser($user->getId());
            $reclamation->setEmail($email);
            $reclamation->setDateReclamation(new \DateTime());
            $reclamation->setSubject($form->get('subject')->getData());
            $reclamation->setRate($form->get('rate')->getData());

            $em->persist($reclamation);
            $em->flush();

            $this->addFlash('success', $existingReclamation ? 'Réclamation mise à jour avec succès' : 'Réclamation envoyée avec succès');
            return $this->redirectToRoute('reclamation_new');
        } else {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        }
    }

    return $this->render('reclamation/new.html.twig', [
        'form' => $form->createView(),
        'reclamation' => $existingReclamation ?? $reclamation,
    ]);
}


    // AJAX endpoint to check if a reclamation exists by email
    #[Route('/check-email', name: 'reclamation_check_email', methods: ['GET'])]
    public function checkEmail(Request $request, ReclamationRepository $reclamationRepository): JsonResponse
    {
        $email = $request->query->get('email');
        $exists = false;

        if ($email) {
            $exists = $reclamationRepository->findOneBy(['email' => $email]) ? true : false;
        }

        return new JsonResponse(['exists' => $exists]);
    }

    // List all reclamations
    #[Route('/', name: 'reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        $reclamations = $reclamationRepository->findAll();

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    // Show a specific reclamation
    #[Route('/{id}', name: 'reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reponse/showrec.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    // Edit an existing reclamation
    #[Route('/{id}/edit', name: 'reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Reclamation $reclamation,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subject = $form->get('subject')->getData();
            if ($reclamation->getEvenement()) {
                $reclamation->setSubject($reclamation->getEvenement()->getNom() . ': ' . $subject);
            } else {
                $reclamation->setSubject($subject);
            }

            $em->flush();
            $this->addFlash('success', 'Réclamation modifiée avec succès');
            return $this->redirectToRoute('reclamation_new');
        }

        return $this->render('reclamation/edit.html.twig', [
            'form' => $form->createView(),
            'reclamation' => $reclamation,
        ]);
    }

    // Delete a reclamation
    #[Route('/{id}/delete', name: 'reclamation_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Reclamation $reclamation,
        EntityManagerInterface $em
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $reclamation->getId(), $request->request->get('_token'))) {
            $em->remove($reclamation);
            $em->flush();
            $this->addFlash('success', 'Réclamation supprimée avec succès');
        }

        return $this->redirectToRoute('reponse_index');
    }
}
