<?php

// src/Controller/TournamentController.php

namespace App\Controller;

use App\Entity\Tournament;
use App\Form\TournamentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateTournamentController extends AbstractController
{
    #[Route('/create-tournament', name: 'app_create_tournament')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $tournament = new Tournament();

        // Création du formulaire
        $form = $this->createForm(TournamentType::class, $tournament);

        // Traitement du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer le tournoi dans la base de données
            $em->persist($tournament);
            $em->flush();

            // Afficher un message de succès
            $this->addFlash('success', 'Le tournoi a été créé avec succès.');

            // Rediriger vers le tableau de bord ou une autre page
            return $this->redirectToRoute('app_dashboard');
        }

        // Rendre la vue avec le formulaire
        return $this->render('create_tournament/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
