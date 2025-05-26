<?php

namespace App\Controller;

use App\Entity\Demandes;
use App\Entity\Users;
use App\Form\DemandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PresenterUploadController extends AbstractController
{
    #[Route('/presenter/submit', name: 'presenter_submit')]
    public function submit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demande = new Demandes();

        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ⚠️ Associe un utilisateur existant si getUser() est null
            $user = $entityManager->getRepository(Users::class)->find(1); // à adapter selon ta logique
            $demande->setUser($user);

            // ✅ Ajoute les champs obligatoires
            $demande->setDateSoumission(new \DateTime());
            $demande->setCreatedAt(new \DateTime());

            $entityManager->persist($demande);
            $entityManager->flush();

            $this->addFlash('success', 'Demande soumise avec succès.');

            return $this->redirectToRoute('presenter_submit');
        }

        return $this->render('presenter_submit/submit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
