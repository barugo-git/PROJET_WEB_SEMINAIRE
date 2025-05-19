<?php
// src/Controller/LogoutController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'app_logout')]
    public function logout(Request $request, SessionInterface $session): Response
    {
        // Invalider la session Symfony
        $session->invalidate();

        // Rediriger vers la page d'accueil ou login
        $response = new RedirectResponse($this->generateUrl('app_home'));

        // Supprimer les cookies liés à la session
        $response->headers->clearCookie($session->getName());

        // Ajouter des en-têtes de sécurité (équivalent PHP)
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->add(['Cache-Control' => 'post-check=0, pre-check=0']);
        $response->headers->set('Pragma', 'no-cache');

        return $response;
    }
}

