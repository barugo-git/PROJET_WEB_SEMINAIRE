<?php
// src/Controller/Admin/AdminDashboardController.php

namespace App\Controller;


use App\Entity\Demandes;
use App\Repository\DemandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin_dashboard/index', name: 'admin_dashboard')]
    public function index(DemandesRepository $demandeRepository): Response
    {
        // Récupère les 10 dernières demandes, ordonnées par date décroissante
        $latestRequests = $demandeRepository->findBy([], ['dateSoumission' => 'DESC'], 10);

        return $this->render('admin_dashboard/index.html.twig', [
            'latestRequests' => $latestRequests,
        ]);
    }

    #[Route('/admin_dashboard/demande/{id}/{action}', name: 'admin_demande_validate')]
    public function validateDemande(Demandes $demande, string $action, EntityManagerInterface $entityManager): RedirectResponse
    {
        if (!in_array($action, ['valide', 'rejete'])) {
            $this->addFlash('danger', 'Action invalide.');
            return $this->redirectToRoute('admin_dashboard');
        }

        $demande->setStatut($action);

        $entityManager->persist($demande);
        $entityManager->flush();

        $this->addFlash('success', sprintf('Demande "%s" a été %s.', $demande->getTopic(), $action));

        return $this->redirectToRoute('admin_dashboard');
    }
}
