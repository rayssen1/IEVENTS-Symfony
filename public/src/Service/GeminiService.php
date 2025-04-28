<?php

namespace App\Service;

use App\Entity\Evenement;
use App\Entity\Eventspeaker;
use App\Entity\Payment;
use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;

class GeminiService
{
    private $httpClient;
    private $entityManager;
    private $apiKey;
    private $apiEndpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct(
        ParameterBagInterface $params,
        HttpClientInterface $httpClient,
        EntityManagerInterface $entityManager
    ) {
        $this->apiKey = $params->get('gemini_api_key');
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
    }

    public function getChatResponse(string $userMessage): string
    {
        // Fetch data for Evenement and Eventspeaker using findAll
        $evenements = $this->entityManager->getRepository(Evenement::class)->findAll();
        $eventspeakers = $this->entityManager->getRepository(Eventspeaker::class)->findAll();

        // Fetch distinct Ticket types
        $ticketTypes = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT t.ticketType')
            ->from(Ticket::class, 't')
            ->getQuery()
            ->getResult();

        // Fetch distinct Payment types
        $paymentTypes = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.paymentType')
            ->from(Payment::class, 'p')
            ->getQuery()
            ->getResult();

        // Build context with selected entity data
        $context = "Tu es un assistant spécialisé dans la gestion d'événements. Réponds aux questions en te basant uniquement sur les données suivantes :\n\n";

        // Evenement context
        $context .= "=== Événements ===\n";
        if (empty($evenements)) {
            $context .= "Aucun événement trouvé.\n";
        } else {
            foreach ($evenements as $evenement) {
                $context .= sprintf(
                    "Titre : %s, Description : %s, Lieu : %s, Nombre de places : %d, Prix : %.2f TND, Date : %s, Statut : %s, Speaker : %s\n",
                    $evenement->getTitre(),
                    $evenement->getDescription(),
                    $evenement->getLieu(),
                    $evenement->getNbPlace(),
                    $evenement->getPrix(),
                    $evenement->getDateEvent()->format('Y-m-d'),
                    $evenement->getStatus(),
                    $evenement->getEventspeakerId() ? $evenement->getEventspeakerId()->getNom() : 'Aucun'
                );
            }
        }

        // Eventspeaker context
        $context .= "\n=== Orateurs ===\n";
        if (empty($eventspeakers)) {
            $context .= "Aucun orateur trouvé.\n";
        } else {
            foreach ($eventspeakers as $speaker) {
                $context .= sprintf(
                    "Nom : %s, Prénom : %s, Description : %s, Statut : %s\n",
                    $speaker->getNom(),
                    $speaker->getPrenom(),
                    $speaker->getDescription(),
                    $speaker->getStatus()
                );
            }
        }

        // Ticket types context
        $context .= "\n=== Types de Tickets ===\n";
        if (empty($ticketTypes)) {
            $context .= "Aucun type de ticket trouvé.\n";
        } else {
            foreach ($ticketTypes as $ticketType) {
                $context .= sprintf(
                    "Type : %s\n",
                    $ticketType['ticketType']
                );
            }
        }

        // Payment types context
        $context .= "\n=== Types de Paiements ===\n";
        if (empty($paymentTypes)) {
            $context .= "Aucun type de paiement trouvé.\n";
        } else {
            foreach ($paymentTypes as $paymentType) {
                $context .= sprintf(
                    "Type : %s\n",
                    $paymentType['paymentType']
                );
            }
        }

        $prompt = $context . "\n\nQuestion de l'utilisateur : " . $userMessage;

        try {
            $response = $this->httpClient->request('POST', $this->apiEndpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'query' => ['key' => $this->apiKey],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'topP' => 0.9,
                        'topK' => 40,
                        'maxOutputTokens' => 1024,
                    ],
                ],
            ]);

            $data = $response->toArray();
            error_log('Gemini API response: ' . print_r($data, true)); // Debug
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Aucune réponse reçue.';

            return $text;
        } catch (HttpExceptionInterface $e) {
            error_log('Gemini HTTP error: ' . $e->getMessage() . ' | Status: ' . $e->getResponse()->getStatusCode());
            return "Erreur lors de la communication avec Gemini : " . $e->getMessage();
        } catch (\Exception $e) {
            error_log('Gemini general error: ' . $e->getMessage());
            return "Erreur lors de la communication avec Gemini : " . $e->getMessage();
        }
    }
}