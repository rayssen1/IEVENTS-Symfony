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
use Doctrine\DBAL\Exception as DBALException;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('/equipment')]
final class EquipmentController extends AbstractController
{
    #[Route('/index', name: 'equipment_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $name = $request->query->get('name');
        $ajax = $request->query->get('ajax');

        $repository = $entityManager->getRepository(Equipment::class);

        if ($name) {
            $equipments = $repository->createQueryBuilder('e')
                ->where('e.name LIKE :searchTerm OR e.type LIKE :searchTerm OR e.description LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $name . '%')
                ->getQuery()
                ->getResult();
        } else {
            $equipments = $repository->findAll();
        }

        if ($ajax) {
            return $this->render('equipment/_equipments_table.html.twig', [
                'equipments' => $equipments,
            ]);
        }
        $totalEquipments = count($equipments);
        $availableEquipments = 0;
        $reservedEquipments = 0;
        $outOfStockEquipments = 0;

        foreach ($equipments as $equipment) {
            $status = strtoupper($equipment->getStatus()); 
            if ($status === Equipment::STATUS_AVAILABLE) {
                $availableEquipments++;
            } elseif ($status === Equipment::STATUS_RESERVED) {
                $reservedEquipments++;
            } elseif ($status === Equipment::STATUS_OUT_OF_STOCK) {
                $outOfStockEquipments++;
            }
        }

        // Calculer les pourcentages
        $availableRate = $totalEquipments > 0 ? ($availableEquipments / $totalEquipments) * 100 : 0;
        $reservedRate = $totalEquipments > 0 ? ($reservedEquipments / $totalEquipments) * 100 : 0;
        $outOfStockRate = $totalEquipments > 0 ? ($outOfStockEquipments / $totalEquipments) * 100 : 0;

        return $this->render('equipment/index.html.twig', [
            'equipments' => $equipments,
            'totalEquipments' => $totalEquipments,
            'availableEquipments' => $availableEquipments,
            'reservedEquipments' => $reservedEquipments,
            'outOfStockEquipments' => $outOfStockEquipments,
            'availableRate' => $availableRate,
            'reservedRate' => $reservedRate,
            'outOfStockRate' => $outOfStockRate,
        ]);
    }

    #[Route('/new', name: 'equipment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        
        $equipment = new Equipment();
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($equipment);
            $hasCustomErrors = false;
        
            $name = $equipment->getName();
            $quantity = $equipment->getQuantity();
        
            if (preg_match('/\d/', $name)) {
                $this->addFlash('error', 'Le nom ne doit pas contenir de chiffres.');
                $hasCustomErrors = true;
            }
        
            if ($quantity === null) {
                $this->addFlash('error', 'Veuillez entrer une quantité.');
                $hasCustomErrors = true;
            } elseif ($quantity <= 0) {
                $this->addFlash('error', 'La quantité doit être un nombre positif.');
                $hasCustomErrors = true;
            } elseif ($quantity >= 1000) {
                $this->addFlash('error', 'La quantité doit être inférieure à 1000.');
                $hasCustomErrors = true;
            }
        
            if (count($errors) === 0 && !$hasCustomErrors) {
                try {
                    $entityManager->persist($equipment);
                    $entityManager->flush();
        
                    $this->addFlash('success', 'Équipement ajouté avec succès.');
                    return $this->redirectToRoute('equipment_index', [], Response::HTTP_SEE_OTHER);
                } catch (DBALException $e) {
                    if (str_contains($e->getMessage(), 'SQLSTATE[22003]')) {
                        $this->addFlash('error', 'La quantité est trop grande pour être enregistrée. Veuillez entrer une valeur plus petite.');
                    } else {
                        $this->addFlash('error', 'Une erreur est survenue lors de l\'ajout de l\'équipement. Veuillez réessayer.');
                    }
                }
            } else {
                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        $this->addFlash('error', $error->getMessage());
                    }
                }
            }
        
            return $this->render('equipment/new.html.twig', [
                'equipment' => $equipment,
                'form' => $form,
            ]);
        }
        
    }

    #[Route('/{id}/edit', name: 'equipment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipment $equipment, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $errors = $validator->validate($equipment);
            $hasCustomErrors = false;

            $name = $equipment->getName();
            $quantity = $equipment->getQuantity();

            if (preg_match('/\d/', $name)) {
                $this->addFlash('error', 'Le nom ne doit pas contenir de chiffres.');
                $hasCustomErrors = true;
            }

            if ($quantity === null) {
                $this->addFlash('error', 'Veuillez entrer une quantité.');
                $hasCustomErrors = true;
            } elseif ($quantity <= 0) {
                $this->addFlash('error', 'La quantité doit être un nombre positif.');
                $hasCustomErrors = true;
            } elseif ($quantity >= 1000) {
                $this->addFlash('error', 'La quantité doit être inférieure à 1000.');
                $hasCustomErrors = true;
            }

            if ($form->isValid() && count($errors) === 0 && !$hasCustomErrors) {
                try {
                    $entityManager->flush();

                    $this->addFlash('success', 'Équipement modifié avec succès.');
                    return $this->redirectToRoute('equipment_index', [], Response::HTTP_SEE_OTHER);
                } catch (DBALException $e) {
                    if (str_contains($e->getMessage(), 'SQLSTATE[22003]')) {
                        $this->addFlash('error', 'La quantité est trop grande pour être enregistrée. Veuillez entrer une valeur plus petite.');
                    } else {
                        $this->addFlash('error', 'Une erreur est survenue lors de la modification de l\'équipement. Veuillez réessayer.');
                    }
                }
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
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
        if ($this->isCsrfTokenValid('delete' . $equipment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($equipment);
            $entityManager->flush();
            $this->addFlash('success', 'Équipement supprimé avec succès.');
        }

        return $this->redirectToRoute('equipment_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/barcode', name: 'equipment_barcode', methods: ['GET'])]
    public function generateBarcode(Equipment $equipment): Response
    {
        $barcodeText = $equipment->getName() . '-' . $equipment->getType();

        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($barcodeText, $generator::TYPE_CODE_128, 2, 50);

        $filename = sprintf('%s-%s-%s.png',
            $equipment->getName(),
            $equipment->getType(),
            (new \DateTime())->format('Y-m-d_H-i-s')
        );

        return new Response($barcode, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
    // In EquipmentController.php

#[Route('/{id}/show', name: 'equipment_show', methods: ['GET'])]
public function show(Equipment $equipment): Response
{
    // Render the show template and pass the equipment to it
    return $this->render('equipment/show.html.twig', [
        'equipment' => $equipment,
    ]);
}


    #[Route('/{id}/maintenance', name: 'equipment_maintenance_show', methods: ['GET'])]
    public function showMaintenance(Equipment $equipment): Response
    {
        $maintenanceRecord = $equipment->getMaintenanceRecords()->first();

        if (!$maintenanceRecord) {
            throw $this->createNotFoundException('Aucun enregistrement de maintenance trouvé pour cet équipement.');
        }

        return $this->redirectToRoute('maintenance_record_show', ['id' => $maintenanceRecord->getId()]);
    }
}
