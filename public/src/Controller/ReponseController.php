<?php

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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/reponse')]
class ReponseController extends AbstractController
{
    #[Route('/', name: 'reponse_index', methods: ['GET'])]
    public function index(ReponseRepository $reponseRepository, ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reponse/index.html.twig', [
            'reponses' => $reponseRepository->findAll(),
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'reponse_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        ReclamationRepository $reclamationRepository,
        EntityManagerInterface $em,
        MailerInterface $mailer
    ): Response {
        $reponse = new Reponse();
        $email = $request->query->get('email');
        $reclamation = $reclamationRepository->findOneBy(['email' => $email]);

        if (!$reclamation) {
            $this->addFlash('error', 'Réclamation introuvable pour cet email.');
            return $this->redirectToRoute('reponse_index');
        }

        $form = $this->createForm(ReponseType::class, $reponse, [
            'email' => $email,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponse->setReclamation($reclamation);
            $reponse->setMessageRec($reclamation->getSubject());
            $reponse->setDateRep(new \DateTime('now', new \DateTimeZone('Africa/Tunis')));

            $em->persist($reponse);
            $em->flush();

            $emailMessage = (new Email())
            ->from('ieventievent289@gmail.com')
            ->to($reclamation->getEmail())
            ->subject('Response to Your Claim')
            ->embedFromPath($this->getParameter('kernel.project_dir') . '/public/images/event-01.jpg', 'ieventImage')
            ->html('
                <div style="font-family: Arial, sans-serif; color: #333;">
                    <!-- Image takes the full width of the email -->
                    <img src="cid:ieventImage" alt="iEvent Image" style="width: 100%; height: auto; margin-bottom: 20px;">
                    <p>Hello,</p>
                    <p>We have responded to your claim as follows:</p>
                    <p style="font-size: 16px;"><strong>' . $reponse->getMessage() . '</strong></p>
                    <p style="text-align: left; font-size: 14px;">Your feedback is invaluable and helps us improve our services and the overall experience for all our users. We truly value your trust and your input.</p>
                    <hr style="margin: 30px 0;">
                    <p style="font-size: 12px; color: #888; text-align: left;">
                        Thank you for using <strong>iEvent</strong>. If you have any further questions or need assistance, feel free to contact us through our platform.
                    </p>
                </div>
            ');
        
        
        


        

            $mailer->send($emailMessage);

            $this->addFlash('success', 'Réponse ajoutée et email envoyé.');
            return $this->redirectToRoute('reponse_index');
        }

        return $this->render('reponse/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'reponse_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Reponse $reponse): Response
    {
        return $this->render('reponse/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }

    #[Route('/{id}/edit', name: 'reponse_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Reponse $reponse, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ReponseType::class, $reponse, [
            'email' => $reponse->getReclamation()->getEmail(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation = $reponse->getReclamation();
            if ($reclamation) {
                $reponse->setMessageRec($reclamation->getSubject());
            }
            $reponse->setDateRep(new \DateTime('now', new \DateTimeZone('Africa/Tunis')));

            $em->flush();
            $this->addFlash('success', 'Réponse mise à jour.');
            return $this->redirectToRoute('reponse_index');
        }

        return $this->render('reponse/edit.html.twig', [
            'form' => $form->createView(),
            'reponse' => $reponse,
        ]);
    }

    #[Route('/{id}', name: 'reponse_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
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
