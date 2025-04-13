<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Service\PasswordHasher;
use Symfony\Component\Form\FormError;
use App\Entity\Session ;



#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route(name: 'app_user_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // $users = $entityManager
        //     ->getRepository(User::class)
        //     ->findAll();

        // return $this->render('user/index.html.twig', [
        //     'users' => $users,
        // ]);
          $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PasswordHasher $passwordHasher, UserRepository $userRepository): Response
    {
        $user = new User();
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted()) {
        $existingUser = $userRepository->findByEmail($user->getEmail());

        if ($existingUser) {
            $form->get('email')->addError(new FormError('This email already exists.'));
        }

        if ($form->isValid()) {
         
            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();
            $session = $request->getSession();
            $sessionKey = bin2hex(random_bytes(32));
            $session->set('session_key', $sessionKey);
            $session->set('user_id', $user->getId());
            $ss = new Session($sessionKey, $user, new \DateTime(), true);
            $entityManager->persist($ss);
            $entityManager->flush();
            if($user->getRole()=='participant'){
                 return $this->redirectToRoute('app_events_index', [], Response::HTTP_SEE_OTHER);
            }
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    return $this->render('user/new.html.twig', [
        'user' => $user,
        'form' => $form,
    ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager,PasswordHasher $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->remove('role');
        $form->handleRequest($request);
       

    
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();    
            if($user->getRole() =='participant'){
                return $this->redirectToRoute('app_events_index');
            }
            return $this->redirectToRoute('app_user_index');
            
    
            
        }
    
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'returnTo' => $request->query->get('returnTo'), // Get from query string
        ]);
    }
    
    
    

    #[Route('/delete/{id}', name: 'app_user_delete', methods: ['GET','POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $userRepository->remove($user->getId());
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
