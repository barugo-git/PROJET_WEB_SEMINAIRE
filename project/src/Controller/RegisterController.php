<?php
namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        UsersRepository $userRepository,
        SessionInterface $session
    ): Response {
        // Redirection si déjà connecté
        if ($session->get('user')) {
            $role = $session->get('user')['role'];
            $redirect = $role === 'admin' ? '/admin/dashboard' : '/presenter/dashboard';
            return new RedirectResponse($redirect);
        }

        $errors = [];
        $formData = $request->request->all();

        if ($request->isMethod('POST')) {
            $nom = trim($formData['nom'] ?? '');
            $email = trim($formData['email'] ?? '');
            $password = $formData['password'] ?? '';
            $confirm = $formData['confirm'] ?? '';
            $role = $formData['role'] ?? 'admin';

            $allowedRoles = ['presenter', 'admin'];

            // Validation des champs
            if (empty($nom) || empty($email) || empty($password) || empty($confirm)) {
                $errors[] = "Tous les champs sont obligatoires.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Format d'email invalide.";
            } elseif (!in_array($role, $allowedRoles, true)) {
                $errors[] = "Rôle invalide.";
            } elseif ($password !== $confirm) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            } elseif (strlen($password) < 8) {
                $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
            } elseif (!preg_match('/[A-Z]/', $password)) {
                $errors[] = "Le mot de passe doit contenir au moins une majuscule.";
            } elseif (!preg_match('/[0-9]/', $password)) {
                $errors[] = "Le mot de passe doit contenir au moins un chiffre.";
            } elseif ($userRepository->findOneBy(['email' => $email])) {
                $errors[] = "Cet email est déjà utilisé.";
            }

            // Si aucun erreur, on enregistre l'utilisateur
            if (empty($errors)) {
                $user = new Users();
                $user->setNom($nom);
                $user->setEmail($email);
                $user->setRole($role);

                // Hachage du mot de passe
                $hashedPassword = $passwordHasher->hashPassword($user, $password);
                $user->setMotDePasse($hashedPassword);

                // Persister l'utilisateur
                $em->persist($user);
                $em->flush();

                $session->set('registration_success', true);
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('register/index.html.twig', [
            'errors' => $errors,
            'old' => $formData,
        ]);
    }
}
