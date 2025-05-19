<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]

    public function index(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $user = $session->get('user'); // Simule la session PHP $_SESSION['user']

        return $this->render('home/index.html.twig', [
            'user' => $user
        ]);
    }
}
