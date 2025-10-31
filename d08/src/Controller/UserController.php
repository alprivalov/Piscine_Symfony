<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\AuthenticatorManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // Symfony 6+


final class UserController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function loginAction( Request $request, UserRepository $userRepository,UserPasswordHasherInterface $passwordHasher,AuthenticationUtils $authUtils): Response
    {

        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        try {
            $user = $userRepository->findOneBy([
                'username' => $username,
            ]);
           $passwordHasher->isPasswordValid($user, $password);
            $this->container->get('security.token_storage')->setToken(
                new UsernamePasswordToken($user, 'main', $user->getRoles())
            );

        } catch (\Exception $exception) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur de connexion'
            ]);
        }

        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
