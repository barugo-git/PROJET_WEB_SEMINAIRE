<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeminarUpcomingController extends AbstractController
{
    #[Route('/seminars/upcoming', name: 'seminars_upcoming')]
    public function index(): Response
    {
        // Chemin corrigé vers le template
        return $this->render('seminar_upcoming/index.html.twig', [
            'message' => 'Voici les séminaires à venir.'
        ]);
    }
}