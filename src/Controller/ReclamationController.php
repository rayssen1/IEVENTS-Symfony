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

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    #[Route('/new', name: 'reclamation_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        EvenementRepository $evenementRepository,
        UserRepository $userRepository,
        ReclamationRepository $reclamationRepository
    ): Response {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        //$session = $request->getSession();
        //$userId = $session->get('user_id');
         //$user = $entityManager->getRepository(User::class)->find($userId); 
         //$email = $user->getEmail();

        $existingReclamation = null;

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $email = $form->get('email')->getData();
                $evenement = $form->get('evenement')->getData();

                $emailConstraint = new Email();
                $emailConstraint->message = 'L\'email que vous avez fourni n\'est pas valide.';
                $errors = $this->validator->validate($email, $emailConstraint);

                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        $this->addFlash('error', $error->getMessage());
                    }
                    return $this->redirectToRoute('reclamation_new');
                }

                $existingReclamation = $reclamationRepository->findOneBy(['email' => $email]);

                // ✅ Utilisation de findByEmail() au lieu de findOneBy()
                $user = $userRepository->findByEmail($email);

                if (!$user) {
                    $this->addFlash('error', 'Utilisateur introuvable avec cet email');
                    return $this->redirectToRoute('reclamation_new');
                }

                if (!$evenement) {
                    $this->addFlash('error', 'Événement introuvable');
                    return $this->redirectToRoute('reclamation_new');
                }

                if ($existingReclamation) {
                    $reclamation = $existingReclamation;
                }

                $reclamation->setIdUser($user->getId());
                $reclamation->setEvenement($evenement);
                $reclamation->setEmail($email);
                $reclamation->setDateReclamation(new \DateTime());

                $subject = $form->get('subject')->getData();
                if ($evenement) {
                    $reclamation->setSubject($evenement->getTitre() . ': ' . $subject);
                } else {
                    $reclamation->setSubject($subject);
                }

                $reclamation->setRate($form->get('rate')->getData());

                $em->persist($reclamation);
                $em->flush();

                if ($existingReclamation) {
                    $this->addFlash('success', 'Réclamation mise à jour avec succès');
                } else {
                    $this->addFlash('success', 'Réclamation envoyée avec succès');
                }

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

    #[Route('/', name: 'reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        $reclamations = $reclamationRepository->findAll();

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/{id}', name: 'reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reponse/showrec.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

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
                $reclamation->setSubject($reclamation->getEvenement()->getTitre() . ': ' . $subject);
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
