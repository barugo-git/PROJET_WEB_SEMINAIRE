<?php
// src/Controller/SeminarArchiveController.php
namespace App\Controller;

use App\Repository\DemandesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SeminarArchiveController extends AbstractController
{
    #[Route('/seminar/archive', name: 'seminar_archive')]
    public function archive(DemandesRepository $demandesRepository, Request $request): Response
    {
        $itemsPerPage = 10;
        $currentPage = max(1, (int)$request->query->get('page', 1));
        $offset = ($currentPage - 1) * $itemsPerPage;

        $seminars = $demandesRepository->findArchivedSeminars($itemsPerPage, $offset);
        $totalItems = $demandesRepository->countArchivedSeminars();
        $totalPages = ceil($totalItems / $itemsPerPage);

        return $this->render('seminar_archive/index.html.twig', [
            'seminars' => $seminars,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
        ]);
    }
}
