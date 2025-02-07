<?php
// src/Controller/JoinTournamentController.php

namespace App\Controller;

use App\Entity\Tournament;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JoinTournamentController extends AbstractController
{
    #[Route('/join-tournament/{id}', name: 'app_join_tournament')]
    public function joinTournament(Request $request, Tournament $tournament, EntityManagerInterface $em): Response
    {
        // Vérifier que l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour rejoindre un tournoi.');
            return $this->redirectToRoute('app_login');
        }
        
        // Vérifier que les inscriptions sont ouvertes (en fonction des dates)
        $now = new \DateTime();
        if ($now < $tournament->getStartInscription() || $now > $tournament->getEndInscription()) {
            $this->addFlash('error', 'Les inscriptions pour ce tournoi ne sont pas ouvertes.');
            return $this->redirectToRoute('app_tournament_details', ['id' => $tournament->getId()]);
        }
        
        // Vérifier que le tournoi n'est pas terminé
        if ($tournament->isFinished()) {
            $this->addFlash('error', 'Ce tournoi est terminé.');
            return $this->redirectToRoute('app_tournament_details', ['id' => $tournament->getId()]);
        }
        
        // Vérifier que l'utilisateur possède au moins une équipe
        $teams = $user->getTeamId();
        if ($teams->isEmpty()) {
            $this->addFlash('error', 'Vous devez créer une équipe avant de pouvoir rejoindre un tournoi.');
            // Redirige vers la création d'équipe en passant l'ID du tournoi pour une inscription automatique après création
            return $this->redirectToRoute('app_create_team', ['tournament' => $tournament->getId()]);
        }
        
        // Sélectionner une équipe non encore inscrite dans ce tournoi
        $selectedTeam = null;
        foreach ($teams as $team) {
            if (!$tournament->getTeams()->contains($team)) {
                $selectedTeam = $team;
                break;
            }
        }
        
        if (!$selectedTeam) {
            $this->addFlash('error', 'Toutes vos équipes sont déjà inscrites à ce tournoi.');
            return $this->redirectToRoute('app_tournament_details', ['id' => $tournament->getId()]);
        }
        
        // Vérifier que le tournoi n'a pas atteint son nombre maximum d'équipes
        if ($tournament->getTeams()->count() >= $tournament->getNbMaxTeam()) {
            $this->addFlash('error', 'Le nombre maximum d\'équipes pour ce tournoi a été atteint.');
            return $this->redirectToRoute('app_tournament_details', ['id' => $tournament->getId()]);
        }
        
        // Inscrire l'équipe sélectionnée au tournoi
        $tournament->addTeam($selectedTeam);
        $em->persist($tournament);
        $em->flush();
        
        $this->addFlash('success', 'Votre équipe a été inscrite au tournoi avec succès.');
        return $this->redirectToRoute('app_dashboard');
    }
}
