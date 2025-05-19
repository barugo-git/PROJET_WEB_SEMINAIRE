<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeminarDownloadController extends AbstractController
{
    #[Route('/seminars/downloads', name: 'seminars_downloads')]
    public function index(): Response
    {
        return $this->render('seminar_download/index.html.twig', [
            'message' => 'Voici les séminaires à télécharger.'
        ]);
    }
}
