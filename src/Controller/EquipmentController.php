<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/equipment')]
final class EquipmentController extends AbstractController
{
    #[Route('/index', name: 'equipment_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $equipments = $entityManager->getRepository(Equipment::class)->findAll();

        return $this->render('equipment/index.html.twig', [
            'equipments' => $equipments,
        ]);
    }

    #[Route('/new', name: 'equipment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $equipment = new Equipment();
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $errors = $validator->validate($equipment);

            if ($form->isValid() && count($errors) === 0) {
                $entityManager->persist($equipment);
                $entityManager->flush();

                return $this->redirectToRoute('equipment_index', [], Response::HTTP_SEE_OTHER);
            }

            // Flash error messages
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        }

        return $this->render('equipment/new.html.twig', [
            'equipment' => $equipment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'equipment_show', methods: ['GET'])]
    public function show(Equipment $equipment): Response
    {
        return $this->render('equipment/show.html.twig', [
            'equipment' => $equipment,
        ]);
    }

    #[Route('/{id}/edit', name: 'equipment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipment $equipment, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $errors = $validator->validate($equipment);

            if ($form->isValid() && count($errors) === 0) {
                $entityManager->flush();

                return $this->redirectToRoute('equipment_index', [], Response::HTTP_SEE_OTHER);
            }

            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        }

        return $this->render('equipment/edit.html.twig', [
            'equipment' => $equipment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'equipment_delete', methods: ['POST'])]
    public function delete(Request $request, Equipment $equipment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($equipment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipment_index', [], Response::HTTP_SEE_OTHER);
    }
}
