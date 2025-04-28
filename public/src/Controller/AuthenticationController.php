<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\PasswordHasher;
use Psr\Log\LoggerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class AuthenticationController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    #[Route('/connect/google', name: 'connect_google_start')]
    public function connectGoogle(ClientRegistry $clientRegistry): RedirectResponse
    {
    return $clientRegistry->getClient('google')->redirect([
        'profile', 'email'
    ]);
    }
    #[Route('/connect/google/check', name: 'connect_google_check')]
    public function connectGoogleCheck(Request $request, ClientRegistry $clientRegistry, EntityManagerInterface $entityManager, PasswordHasher $passwordHasher, UserRepository $userRepository)
    {
   
        $client = $clientRegistry->getClient('google');

        // Un seul appel pour échanger code → token
        $accessToken = $client->getAccessToken();
    
        // Puis on récupère l’utilisateur à partir du token
        /** @var \League\OAuth2\Client\Provider\GoogleUser $user */
        $user = $client->fetchUserFromToken($accessToken);
        $firstName = $user->getFirstName();        
        $lastName = $user->getLastName();          
        $googleId = $user->getId(); 
        $email  = $user->getEmail();
        $us = $userRepository->findByEmail($email);
        if($us==null){
            $us = new User($email,$lastName,$lastName,$googleId,'participant');
            $entityManager->persist($us);
            $entityManager->flush();  
        }
        $session = $request->getSession();
        $sessionKey = bin2hex(random_bytes(32));
        $session->set('session_key', $sessionKey);
        $session->set('user_id', $us->getId());
        $ss = new Session($sessionKey, $us, new \DateTime(), true);
        $entityManager->persist($ss);
        $entityManager->flush();
        return $this->redirectToRoute('app_events_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/authentication', name: 'app_authentication', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        UserRepository $userRepository,
        PasswordHasher $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $errors = [];
        $debugInfo = [];
        $message= null;

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // $debugInfo['email'] = $email;
            // $this->logger->debug('POST request received. Email: {email}', ['email' => $email]);

            if (empty($email) || empty($password)) {
                $errors['email'] = 'Email/Username is required.';
                $errors['password'] = 'Password is required.';
                $this->logger->debug('Validation failed: Email or password empty.');
            } else {
                $user = $userRepository->findByEmail($email);
                $this->logger->debug('User lookup result: {user}', ['user' => $user ? $user->getId() : 'null']);

                if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
                    $errors['email'] = 'Email or password are invalid.';
                    $this->logger->debug('Invalid credentials for email: {email}', ['email' => $email]);
                } else {
                    if($user->getState() =='desactive'){
                        $message = 'your account has been desactivated';
                        
                    }
                    else{
                        try {
                            $session = $request->getSession();
                            $sessionKey = bin2hex(random_bytes(32));
                            $session->set('session_key', $sessionKey);
                            $session->set('user_id', $user->getId());
                            $ss = new Session($sessionKey, $user, new \DateTime(), true);
                            $entityManager->persist($ss);
                            $entityManager->flush();
                            //if admin bech nheza adminDashboard kana organisateur kifkif kana user 3adi lel front office
                            if($user->getRole()=='participant'){
                                return $this->redirectToRoute('app_events_index', [], Response::HTTP_SEE_OTHER);
                            }
                            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);    
                        } catch (\Exception $e) {
                            $this->logger->error('Failed to save session: {error}', ['error' => $e->getMessage()]);
                            $errors['general'] = 'Error: ' . $e->getMessage();
                            $debugInfo['exception'] = $e->getMessage();
                        }
                    }
                    
                }
            }
        }

        return $this->render('authentication/index.html.twig', [
            'errors' => $errors,
            'debug_info' => $debugInfo,
            'message' => $message,
        ]);
    }
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(
    Request $request,
    EntityManagerInterface $entityManager
        ): Response {
    $symfonySession = $request->getSession();
    $sessionKey = $symfonySession->get('session_key');
    if ($sessionKey) {
        $sessionEntity = $entityManager->getRepository(Session::class)->findOneBy([
            'id' => $sessionKey,
        ]);
        if ($sessionEntity) {
            $sessionEntity->setLogout_time(new \DateTime());
            $sessionEntity->setIs_active(false);
            $entityManager->flush();
        }
        // Clear Symfony session
        $symfonySession->remove('session_key');
        $symfonySession->invalidate();
    }
    return $this->redirectToRoute('app_authentication');
}

}
