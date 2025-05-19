<?php
// src/Controller/PresenterController.php
namespace App\Controller;

use App\Entity\Users; // Correctement référencer la classe 'Users'
use App\Repository\DemandesRepository; // Correctement référencer DemandesRepository
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class PresenterController extends AbstractController
{
    #[Route('/presenter/dashboard', name: 'presenter_dashboard')]
    public function dashboard(DemandesRepository $demandesRepository, RequestStack $requestStack): Response
    {
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // Vérification si l'utilisateur est authentifié et a le rôle 'presenter'
        if (!$user || $user->getRole() !== 'presenter') {
            return $this->redirectToRoute('app_login');  // Rediriger vers la page de login si l'utilisateur n'est pas un 'presenter'
        }

        // Récupération des demandes avec le statut et présentation associés à l'utilisateur connecté
        // Vous devrez vous assurer que la méthode 'findRequestsWithStatusAndPresentation' existe dans le repository
        $requests = $demandesRepository->findRequestsWithStatusAndPresentation($user->getId());

        // Rendu de la vue 'dashboard.html.twig' avec les données nécessaires (demandes et utilisateur)
        return $this->render('presenter/dashboard.html.twig', [
            'requests' => $requests,  // Passer les demandes à la vue
            'user' => $user,  // Passer les informations de l'utilisateur à la vue
        ]);
    }
}
