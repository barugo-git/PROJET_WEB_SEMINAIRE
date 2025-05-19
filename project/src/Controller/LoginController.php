<?php
// src/Controller/LoginController.php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(
        Request $request,
        EntityManagerInterface $em,
        SessionInterface $session
    ): Response {
        // Vérifie si l'utilisateur est déjà connecté
        if ($session->has('user')) {
            $role = $session->get('user')['role'];
            
            // Évite la boucle de redirection
            if ($request->getPathInfo() !== $this->generateUrl($role === 'admin' ? 'admin_dashboard' : 'presenter_dashboard')) {
                return $this->redirectToRoute($role === 'admin' ? 'admin_dashboard' : 'presenter_dashboard');
            }
        }

        $errors = [];

        if ($request->isMethod('POST')) {
            $email = trim($request->request->get('email'));
            $password = $request->request->get('password');

            if (empty($email) || empty($password)) {
                $errors[] = 'Tous les champs sont obligatoires.';
            } else {
                $userRepo = $em->getRepository(Users::class);
                $user = $userRepo->findOneBy(['email' => $email]);

                if ($user && password_verify($password, $user->getMotDePasse())) {
                    $session->set('user', [
                        'id' => $user->getId(),
                        'name' => $user->getNom(),
                        'email' => $user->getEmail(),
                        'role' => $user->getRole(),
                    ]);

                    return $this->redirectToRoute($user->getRole() === 'admin' ? 'admin_dashboard' : 'presenter_dashboard');
                } else {
                    $errors[] = 'Identifiants incorrects.';
                }
            }
        }

        return $this->render('login/index.html.twig', [
            'errors' => $errors,
            'email' => $request->request->get('email', ''),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->remove('user');
        return $this->redirectToRoute('app_login');
    }
}