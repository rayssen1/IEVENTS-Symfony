<?php

namespace App\Controller;


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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\User;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/user')]
final class UserController extends AbstractController
{
    private HttpClientInterface $httpClient;

   public function __construct(HttpClientInterface $httpClient)
    {
    $this->httpClient = $httpClient;
    }
    #[Route(name: 'app_user_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $qb = $entityManager->getRepository(User::class)
                 ->createQueryBuilder('u');
    
        if ($search) {
            $qb->andWhere('u.nom   LIKE :s OR 
                           u.prenom LIKE :s OR 
                           u.email  LIKE :s')
               ->setParameter('s', '%'.$search.'%');
        }
    
        $users = $paginator->paginate(
            $qb->getQuery(),
            $request->query->getInt('page', 1),
            5
        ); 
        $sessions = $entityManager->getRepository(Session::class)->findAll();
        $loginHeatmap = []; // [day][hour] => count

        foreach ($sessions as $session) {
                $loginTime = $session->getLogin_time();
                $hour = (int) $loginTime->format('G');
                $dayOfWeek = (int) $loginTime->format('w'); // 0 (Sun) to 6 (Sat)

                // Convert to string label for better chart display
                $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                $dayLabel = $days[$dayOfWeek];

                if (!isset($loginHeatmap[$dayLabel])) {
                    $loginHeatmap[$dayLabel] = array_fill(0, 24, 0);
                }
                $loginHeatmap[$dayLabel][$hour]++;
            }

            // Role distribution
            $roleDistribution = ['admin' => 0, 'participant' => 0, 'organisateur' => 0];
            foreach ($users as $user) {
                $role = $user->getRole();
                $roleDistribution[$role] = ($roleDistribution[$role] ?? 0) + 1;
            }

            // State distribution
            $stateDistribution = ['active' => 0, 'desactive' => 0];
            foreach ($users as $user) {
                $state = $user->getState();
                $stateDistribution[$state] = ($stateDistribution[$state] ?? 0) + 1;
            }

            // Extract keys/values separately for Twig
            $roleLabels = array_keys($roleDistribution);
            $roleCounts = array_values($roleDistribution);

            $stateLabels = array_keys($stateDistribution);
            $stateCounts = array_values($stateDistribution);
            if ($request->isXmlHttpRequest()) {
                // use renderView so you don’t need a Response wrapper
                $html = $this->renderView(
                    'user/_user_rows.html.twig',
                    ['users' => $users]
                );
                return new Response($html);
            }
            return $this->render('user/index.html.twig', [
                'users' => $users,
                'roleLabels' => $roleLabels,
                'roleCounts' => $roleCounts,
                'stateLabels' => $stateLabels,
                'stateCounts' => $stateCounts,
                'loginHeatmap' => $loginHeatmap,
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
        $recaptchaResponse = $request->request->get('g-recaptcha-response');
        $captchaValid = false;
        if ($recaptchaResponse) {
            $response = $this->httpClient->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'body' => [
                    'secret' => '6LctDBwrAAAAAPpN4aC7ZQ--_k6Zr-l9lHBnKaup', 
                    'response' => $recaptchaResponse,
                    'remoteip' => $request->getClientIp(),
                ],
            ]);
            $captchaData = $response->toArray();
            $captchaValid = $captchaData['success'] ?? false;
        }

        if (!$captchaValid) {
            $form->addError(new FormError('Captcha verification failed. Please try again.'));
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
    #[Route('/forget-password-email', name: 'app_user_forgetPasswordEmail', methods: ['GET', 'POST'])]
    public function forgetPasswordEmail(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        MailerInterface $mailer
    ): Response {
        $errors = [];
    
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
    
            if (empty($email)) {
                $this->addFlash('failed', 'Email field are required');
                return $this->redirectToRoute('app_user_forgetPasswordEmail');
            } else {
                $user = $userRepository->findByEmail($email);
                if (!$user) {
                $errors['email'] = 'Email is invalid.';
                } else {
                    $code = random_int(100000, 999999);
                    $session = $request->getSession();
                    $session->set('reset_code', $code);
                    $session->set('reset_code_sent_at', time());
                    $session->set('reset_user_id', $user->getId());

                    $emailMessage = (new Email())
                        ->from('klichealaeddine@gmail.com')
                        ->to($user->getEmail())
                        ->subject('Password Reset Code')
                        ->text("Your password reset code is: $code");
                    $mailer->send($emailMessage);
                    $this->addFlash('success', 'Reset code sent to your email.');
                    return $this->redirectToRoute('app_user_forgetPasswordCode');
                }
            }
            }
        return $this->render('user/forget-password-email.html.twig');
    }
    #[Route('/forget-password-code', name: 'app_user_forgetPasswordCode', methods: ['GET', 'POST'])]
    public function forgetPasswordCode(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
    ): Response {
        $errors = [];
    
        if ($request->isMethod('POST')) {
            $code = $request->request->get('code');
            $session = $request->getSession();
            if (empty($code)) {
                $this->addFlash('failed', 'All fields are required');
                return $this->redirectToRoute('app_user_forgetPasswordCode');
            } 
            elseif($code != $session->get('reset_code') ){

                   $this->addFlash('failed', 'Reset code is invalid.');
                   return $this->redirectToRoute('app_user_forgetPasswordCode');
            }else{
                $this->addFlash('success', 'Reset code is valid.');
                return $this->redirectToRoute('app_user_forgetPasswordConfirmation');
            }
        }
        return $this->render('user/forget-password-code.html.twig');
    }
    #[Route('/forget-password-confirmation', name: 'app_user_forgetPasswordConfirmation', methods: ['GET', 'POST'])]
    public function forgetPasswordConfirmation(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        PasswordHasher $passwordHasher
    ): Response {
        $errors = [];
        if ($request->isMethod('POST')) {
            $newPassword = $request->request->get('newPassword');
            $confirmPassword = $request->request->get('confirmPassword');
            if (empty($newPassword)||empty($confirmPassword)) {
                $this->addFlash('failed', 'All fields are required');
                return $this->redirectToRoute('app_user_forgetPasswordConfirmation');            } 
            elseif($confirmPassword != $newPassword){
                   $this->addFlash('failed', 'Please check your password');
                   return $this->redirectToRoute('app_user_forgetPasswordConfirmation');
            }elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $newPassword)) {
                $this->addFlash('failed', 'Password must be at least 8 characters long, contain at least one uppercase letter and one digit.');
                return $this->redirectToRoute('app_user_forgetPasswordConfirmation');
            }
            else{
                $session = $request->getSession();
                $user_id = $session->get('reset_user_id');
                $user = $userRepository->findById($user_id);
                $hashedPassword = $passwordHasher->hashPassword($user, $confirmPassword);
                $user->setPassword($hashedPassword);
                $entityManager->persist($user);
                $entityManager->flush(); 
                $this->addFlash('success', 'your password reset sucessfully ');
                return $this->redirectToRoute('app_user_forgetPasswordConfirmation');
            }
        }
        return $this->render('user/forget-password-confirmation.html.twig');
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