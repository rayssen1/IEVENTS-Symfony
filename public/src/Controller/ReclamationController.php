<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\EvenementRepository;
use App\Repository\UserRepository;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
private $validator;
private $httpClient;

public function __construct(ValidatorInterface $validator, HttpClientInterface $httpClient)
{
$this->validator = $validator;
$this->httpClient = $httpClient;
}

private function cleanText(string $text): string
{
try {
$response = $this->httpClient->request('GET', 'https://www.purgomalum.com/service/json', [
'query' => [
'text' => $text,
'add' => 'damn,crap,hell,shit',
'fill_text' => '[REMOVED]'
]
]);
$data = $response->toArray();
return isset($data['result']) ? str_replace('[REMOVED]', '', $data['result']) : $text;
} catch (\Exception $e) {
return $text;
}
}

private function detectLanguage(string $text): ?string
{
try {
$response = $this->httpClient->request('POST', 'https://ws.detectlanguage.com/0.2/detect', [
'headers' => [
'Authorization' => 'Bearer 7eb591ac417f6cde62adc8e842282ddf',
],
'body' => [
'q' => $text,
],
]);
$data = $response->toArray();
return $data['data']['detections'][0]['language'] ?? null;
} catch (\Exception $e) {
return null;
}
}

#[Route('/new', name: 'reclamation_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $em, EvenementRepository $evenementRepository, UserRepository $userRepository, ReclamationRepository $reclamationRepository): Response
{
$reclamation = new Reclamation();
$form = $this->createForm(ReclamationType::class, $reclamation);
$form->handleRequest($request);

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
$cleanedSubject = $this->cleanText($subject);
$language = $this->detectLanguage($cleanedSubject);

if ($language !== 'en') {
$this->addFlash('error', 'Le message doit être en anglais !');
return $this->redirectToRoute('reclamation_new');
}

if ($evenement) {
$reclamation->setSubject($evenement->getTitre() . ': ' . $cleanedSubject);
} else {
$reclamation->setSubject($cleanedSubject);
}

$reclamation->setRate($form->get('rate')->getData());

$em->persist($reclamation);
$em->flush();

$message = $existingReclamation
? 'Réclamation mise à jour avec succès'
: 'Réclamation envoyée avec succès';

$this->addFlash('success', $message);
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
'detected_language' => $language ?? 'en', // ✅ Add this line
]);

}

#[Route('/{id}/edit', name: 'reclamation_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $em): Response
{
$form = $this->createForm(ReclamationType::class, $reclamation);
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
$subject = $form->get('subject')->getData();
$cleanedSubject = $this->cleanText($subject);
$language = $this->detectLanguage($cleanedSubject);

if ($language !== 'en') {
$this->addFlash('error', 'Le message doit être en anglais !');
return $this->redirectToRoute('reclamation_edit', ['id' => $reclamation->getId()]);
}

if ($reclamation->getEvenement()) {
$reclamation->setSubject($reclamation->getEvenement()->getTitre() . ': ' . $cleanedSubject);
} else {
$reclamation->setSubject($cleanedSubject);
}

$reclamation->setDateReclamation(new \DateTime());

$em->flush();

$this->addFlash('success', 'Réclamation modifiée avec succès');
return $this->redirectToRoute('reclamation_new');
}

return $this->render('reclamation/edit.html.twig', [
'form' => $form->createView(),
'reclamation' => $reclamation,
'detected_language' => $language ?? 'en', // ✅ Add this line
]);
}


#[Route('/', name: 'reclamation_index', methods: ['GET'])]
public function index(ReclamationRepository $reclamationRepository): Response
{
return $this->render('reclamation/base-front.html.twig', [
'reclamations' => $reclamationRepository->findAll(),
]);
}

#[Route('/{id}', name: 'reclamation_show', methods: ['GET'], requirements: ['id' => '\d+'])]
public function show(Reclamation $reclamation): Response
{
return $this->render('reponse/showrec.html.twig', [
'reclamation' => $reclamation,
]);
}

#[Route('/{id}/delete', name: 'reclamation_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $em): Response
{
if ($this->isCsrfTokenValid('delete' . $reclamation->getId(), $request->request->get('_token'))) {
$em->remove($reclamation);
$em->flush();
$this->addFlash('success', 'Réclamation supprimée avec succès');
}

return $this->redirectToRoute('reponse_index');
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

#[Route('/organisateur/statistics', name: 'organisateur_statistics')]
public function statistics(
EntityManagerInterface $em,
ReclamationRepository $reclamationRepo,
EvenementRepository $evenementRepo,
ReponseRepository $reponseRepo
): Response {
$today = new \DateTime('now', new \DateTimeZone('Africa/Tunis'));
$oneYearAgo = (clone $today)->modify('-1 year')->modify('first day of this month');

$conn = $em->getConnection();

try {
// 1. Monthly statistics (Bar chart)
$sql = "
SELECT
DATE_FORMAT(dateReclamation, '%Y-%m') as month,
COUNT(*) as count
FROM reclamation
WHERE dateReclamation >= :date
GROUP BY month
ORDER BY month ASC
";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':date', $oneYearAgo->format('Y-m-d'));
$result = $stmt->executeQuery();
$data = $result->fetchAllAssociative();



$months = [];
$counts = [];

// Ensure proper date range for the last year
$period = new \DatePeriod(
$oneYearAgo,
new \DateInterval('P1M'),
$today->modify('first day of next month')
);

foreach ($period as $dt) {
$key = $dt->format('Y-m');
$months[] = $dt->format('M Y');
$found = false;

foreach ($data as $row) {
if ($row['month'] === $key) {
$counts[] = $row['count'];
$found = true;
break;
}
}

if (!$found) {
$counts[] = 0;
}
}

// 2. Pie chart stats by event
$sql2 = "
SELECT
e.titre as event_title,
COUNT(r.id) as count
FROM reclamation r
JOIN evenement e ON r.idEvent = e.id
GROUP BY e.titre
";

$stmt2 = $conn->prepare($sql2);
$result2 = $stmt2->executeQuery();
$eventStats = $result2->fetchAllAssociative();

$eventTitles = [];
$eventCounts = [];

foreach ($eventStats as $row) {
$eventTitles[] = $row['event_title'];
$eventCounts[] = $row['count'];
}

// 3. ADD: Summary Counts
$reclamationsCount = $reclamationRepo->count([]);
$eventsCount = $evenementRepo->count([]);

// 3bis. Count of resolved based on last response (etat = 'TREATED')
$sql3 = "
SELECT COUNT(*) as treated_count
FROM (
SELECT r1.idRec, r1.etat
FROM reponse r1
INNER JOIN (
SELECT idRec, MAX(dateRep) as latest_date
FROM reponse
GROUP BY idRec
) r2 ON r1.idRec = r2.idRec AND r1.dateRep = r2.latest_date
WHERE r1.etat = 'TREATED'
) latest_treated
";

$stmt3 = $conn->prepare($sql3);
$result3 = $stmt3->executeQuery();
$resolvedCount = (int) $result3->fetchOne();

return $this->render('reclamation/statistics.html.twig', [
'months' => json_encode($months),
'counts' => json_encode($counts),
'eventTitles' => json_encode($eventTitles),
'eventCounts' => json_encode($eventCounts),
'reclamationsCount' => $reclamationsCount,
'eventsCount' => $eventsCount,
'resolvedCount' => $resolvedCount,
]);
} catch (\Exception $e) {
// Handle any SQL or connection errors gracefully
return new Response("Error: " . $e->getMessage());
}
}

#[Route('/test-profanity', name: 'test_profanity')]
public function testProfanity(): Response
{
$text = 'this is a damn test';
$cleaned = $this->cleanText($text);

return new Response("Original: $text <br> Cleaned: $cleaned");
}










}