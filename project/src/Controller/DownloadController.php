<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    #[Route('/downloads', name: 'app_downloads')]
    public function index(): Response
    {
        // Chemin corrigé vers le template
        return $this->render('home/downloads.html.twig', [
            'title' => 'Télécargement',
        ]);
    }
}