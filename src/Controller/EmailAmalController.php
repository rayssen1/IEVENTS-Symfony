<?php

namespace App\Controller;

use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class EmailAmalController extends AbstractController
{
    private EquipmentRepository $equipmentRepository;
    private MailerInterface $mailer;

    public function __construct(EquipmentRepository $equipmentRepository, MailerInterface $mailer)
    {
        $this->equipmentRepository = $equipmentRepository;
        $this->mailer = $mailer;
    }

    #[Route('/api/stock/alert', name: 'stock_alert', methods: ['GET'])]
    public function stockAlert(): JsonResponse
    {
        // Fetch equipments with quantity < 50
        $lowStockEquipments = $this->equipmentRepository->findLowStockEquipments(50);
        

        if (count($lowStockEquipments) > 0) {
            echo('Here');
            $email = (new Email())
                ->from('hello@demomailtrap.co') // <- Must match your SMTP "mail-from"
                ->to('trad.amal02@gmail.com')    // <- Receiving email
                ->subject('🚨 Alerte de stock faible')
                ->text('This is the text version of the email.')
                ->html($this->renderView('emails/low_stock_alert.html.twig', [
                    'equipments' => $lowStockEquipments,
                ]));

            $this->mailer->send($email);

            return new JsonResponse(['status' => 'success', 'message' => 'Email de stock faible envoyé.'], Response::HTTP_OK);
        }

        return new JsonResponse(['status' => 'success', 'message' => 'Aucun équipement en stock faible.'], Response::HTTP_OK);
    }
}
