<?php

namespace App\Controller;

use App\Repository\DemandesRepository;
use App\Repository\ProgrammationsRepository;
use App\Repository\PresentationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PresenterDashboardController extends AbstractController
{
    #[Route('/presenter/dashboard', name: 'presenter_dashboard')]
    public function index(
        DemandesRepository $demandesRepository,
        ProgrammationsRepository $programmationsRepository,
        PresentationsRepository $presentationsRepository,
        Request $request,
        SessionInterface $session
    ): Response {
        // Vérification de la session
        $user = $session->get('user');

        if (!$user || $user['role'] !== 'presenter') {
            return $this->redirectToRoute('app_login');
        }

        // Pagination
        $itemsPerPage = 10;
        $currentPage = max(1, (int) $request->query->get('page', 1));
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Comptage total des demandes
        $totalItems = $demandesRepository->countByUser($user['id']);
        $totalPages = ceil($totalItems / $itemsPerPage);

        // Récupération des demandes avec pagination
        $requests = $demandesRepository->findRequestsForPresenter($user['id'], $itemsPerPage, $offset);

        return $this->render('presenter_dashboard/index.html.twig', [
            'requests' => $requests,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'user' => $user,
        ]);
    }
}
