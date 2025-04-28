<?php

namespace App\Service;

use App\Entity\Evenement;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GoogleCalendarService
{
    private Google_Client $client;
    private SessionInterface $session;

    public function __construct(string $clientId, string $clientSecret, RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();

        $this->client = new Google_Client();
        $this->client->setClientId($clientId);
        $this->client->setClientSecret($clientSecret);
        $this->client->setRedirectUri('http://localhost:8000/evenement/google-callback');
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    }

    public function getAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    public function handleCallback(string $code): void
    {
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);

        if (isset($accessToken['error'])) {
            throw new \Exception('Erreur lors de la récupération du jeton d’accès : ' . $accessToken['error']);
        }

        $this->session->set('google_access_token', $accessToken);
    }

    public function createEvent(Evenement $evenement): bool
    {
        $accessToken = $this->session->get('google_access_token');

        if (!$accessToken) {
            return false;
        }

        $this->client->setAccessToken($accessToken);

        if ($this->client->isAccessTokenExpired()) {
            $refreshToken = $accessToken['refresh_token'] ?? null;

            if ($refreshToken) {
                $newAccessToken = $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
                $this->session->set('google_access_token', $newAccessToken);
                $this->client->setAccessToken($newAccessToken);
            } else {
                return false;
            }
        }

        $service = new Google_Service_Calendar($this->client);

        $event = new Google_Service_Calendar_Event([
            'summary' => $evenement->getTitre(),
            'description' => $evenement->getDescription(),
            'start' => [
                'dateTime' => $evenement->getDateEvent()->format('c'),
                'timeZone' => 'Europe/Paris',
            ],
            'end' => [
                'dateTime' => $evenement->getDateEvent()->modify('+1 hour')->format('c'),
                'timeZone' => 'Europe/Paris',
            ],
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 30],
                ],
            ],
        ]);

        try {
            $service->events->insert('primary', $event);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getEvents(\DateTime $start, \DateTime $end): array
    {
        $accessToken = $this->session->get('google_access_token');

        if (!$accessToken) {
            return [];
        }

        $this->client->setAccessToken($accessToken);

        if ($this->client->isAccessTokenExpired()) {
            $refreshToken = $accessToken['refresh_token'] ?? null;

            if ($refreshToken) {
                $newAccessToken = $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
                $this->session->set('google_access_token', $newAccessToken);
                $this->client->setAccessToken($newAccessToken);
            } else {
                return [];
            }
        }

        $service = new Google_Service_Calendar($this->client);

        try {
            $events = $service->events->listEvents('primary', [
                'timeMin' => $start->format(\DateTime::RFC3339),
                'timeMax' => $end->format(\DateTime::RFC3339),
                'singleEvents' => true,
                'orderBy' => 'startTime',
            ]);

            $formattedEvents = [];
            foreach ($events->getItems() as $event) {
                $formattedEvents[] = [
                    'id' => $event->getId(),
                    'summary' => $event->getSummary(),
                    'description' => $event->getDescription(),
                    'start' => $event->getStart()->getDateTime() ?? $event->getStart()->getDate(),
                    'end' => $event->getEnd()->getDateTime() ?? $event->getEnd()->getDate(),
                    'allDay' => $event->getStart()->getDateTime() ? false : true,
                ];
            }

            return $formattedEvents;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function updateEvent(string $eventId, array $eventData): bool
    {
        $accessToken = $this->session->get('google_access_token');

        if (!$accessToken) {
            return false;
        }

        $this->client->setAccessToken($accessToken);

        if ($this->client->isAccessTokenExpired()) {
            $refreshToken = $accessToken['refresh_token'] ?? null;

            if ($refreshToken) {
                $newAccessToken = $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
                $this->session->set('google_access_token', $newAccessToken);
                $this->client->setAccessToken($newAccessToken);
            } else {
                return false;
            }
        }

        $service = new Google_Service_Calendar($this->client);

        try {
            $event = $service->events->get('primary', $eventId);
            $event->setSummary($eventData['summary']);
            $event->setStart(new \Google_Service_Calendar_EventDateTime([
                'dateTime' => $eventData['allDay'] ? null : $eventData['start'],
                'date' => $eventData['allDay'] ? $eventData['start'] : null,
                'timeZone' => 'Europe/Paris',
            ]));
            $event->setEnd(new \Google_Service_Calendar_EventDateTime([
                'dateTime' => $eventData['allDay'] ? null : $eventData['end'],
                'date' => $eventData['allDay'] ? $eventData['end'] : null,
                'timeZone' => 'Europe/Paris',
            ]));

            $service->events->update('primary', $eventId, $event);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteEvent(string $eventId): bool
    {
        $accessToken = $this->session->get('google_access_token');

        if (!$accessToken) {
            return false;
        }

        $this->client->setAccessToken($accessToken);

        if ($this->client->isAccessTokenExpired()) {
            $refreshToken = $accessToken['refresh_token'] ?? null;

            if ($refreshToken) {
                $newAccessToken = $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
                $this->session->set('google_access_token', $newAccessToken);
                $this->client->setAccessToken($newAccessToken);
            } else {
                return false;
            }
        }

        $service = new Google_Service_Calendar($this->client);

        try {
            $service->events->delete('primary', $eventId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function hasValidAccessToken(): bool
    {
        $accessToken = $this->session->get('google_access_token');

        if (!$accessToken) {
            return false;
        }

        $this->client->setAccessToken($accessToken);

        return !$this->client->isAccessTokenExpired();
    }

    public function clearAccessToken(): void
    {
        $this->session->remove('google_access_token');
    }
}