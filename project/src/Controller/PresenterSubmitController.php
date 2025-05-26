<?php

namespace App\Controller;

use App\Entity\Demandes;
use App\Form\DemandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PresenterSubmitController extends AbstractController
{
    #[Route('/presenter/submit', name: 'presenter_submit')]
    public function submit(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
        $demande = new Demandes();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichier = $form->get('fichier')->getData();

            if ($fichier) {
                $originalFilename = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $fichier->guessExtension();

                try {
                    $fichier->move(
                        $this->getParameter('presentation_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Erreur lors du téléchargement du fichier.');
                    return $this->redirectToRoute('presenter_submit');
                }

                // Enregistre le chemin du fichier dans l’entité si besoin
                $demande->setTopic($newFilename); // on réutilise le champ 'topic' pour stocker le nom de fichier
            }

            // Associer l'utilisateur connecté
            $demande->setUser($this->getUser());
            $demande->setStatut('en_attente');

            $em->persist($demande);
            $em->flush();

            $this->addFlash('success', 'Demande de séminaire soumise avec succès.');
            return $this->redirectToRoute('presenter_dashboard');
        }

        return $this->render('presenter_submit/submit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
