<?php
// src/Controller/PresenterSubmitController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PresenterSubmitController extends AbstractController
{
    #[Route('/presenter/submit', name: 'presenter_submit')]
    public function submit(): Response
    {
        // À compléter : afficher un formulaire ou une page pour soumettre une nouvelle demande
        return $this->render('presenter_submit/submit.html.twig', [
            'controller_name' => 'PresenterSubmitController',
        ]);
    }
}
