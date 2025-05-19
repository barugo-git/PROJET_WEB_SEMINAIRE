<?php
// src/Controller/Admin/AdminDashboardController.php

namespace App\Controller;

use App\Repository\DemandesRepository;
use App\Repository\ProgrammationsRepository;
use App\Repository\UsersRepository;
use App\Repository\PresentationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin_dashboard/dashboard', name: 'admin_dashboard')]
    public function index(
        UsersRepository $userRepository,
        DemandesRepository $demandeRepository,
        ProgrammationsRepository $programmationRepository,
        PresentationsRepository $presentationRepository
    ): Response {
        // Récupération des statistiques
        $stats = [
            'totalUsers' => $userRepository->count([]),
            'presenters' => $userRepository->count(['role' => 'presenter']),
            'admins' => $userRepository->count(['role' => 'admin']),
            'totalRequests' => $demandeRepository->count([]),
            'pending' => $demandeRepository->count(['statut' => 'en_attente']),
            'approved' => $demandeRepository->count(['statut' => 'valide']),
            'rejected' => $demandeRepository->count(['statut' => 'rejete']),
            'presentations' => $presentationRepository->count([]),
        ];

        // Dernières demandes
        $latestRequests = $demandeRepository->findLatestRequests(5);

        // Prochains séminaires
        $upcomingSeminars = $programmationRepository->findUpcomingSeminars(5);

        return $this->render('admin_dashboard/index.html.twig', [
            'stats' => $stats,
            'latestRequests' => $latestRequests,
            'upcomingSeminars' => $upcomingSeminars,
        ]);
    }
}