<?php

namespace App\Controller;

use App\Entity\Maintenancerecord;
use App\Form\MaintenanceRecordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/maintenance_record')]
final class MaintenanceRecordController extends AbstractController
{
    #[Route('/index', name: 'maintenance_record_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $maintenanceRecords = $entityManager->getRepository(Maintenancerecord::class)->findAll();

        return $this->render('maintenancerecord/index.html.twig', [
            'maintenance_records' => $maintenanceRecords,
        ]);
    }

    #[Route('/new', name: 'maintenance_record_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $maintenanceRecord = new Maintenancerecord();
        $form = $this->createForm(MaintenanceRecordType::class, $maintenanceRecord);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($maintenanceRecord);
            $entityManager->flush();

            return $this->redirectToRoute('maintenance_record_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('maintenancerecord/new.html.twig', [
            'maintenance_record' => $maintenanceRecord,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'maintenance_record_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Maintenancerecord $maintenanceRecord, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaintenanceRecordType::class, $maintenanceRecord);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('maintenance_record_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('maintenancerecord/edit.html.twig', [
            'maintenance_record' => $maintenanceRecord,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'maintenance_record_delete', methods: ['POST'])]
    public function delete(Request $request, Maintenancerecord $maintenanceRecord, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maintenanceRecord->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($maintenanceRecord);
            $entityManager->flush();
        }

        return $this->redirectToRoute('maintenance_record_index', [], Response::HTTP_SEE_OTHER);
    }
}