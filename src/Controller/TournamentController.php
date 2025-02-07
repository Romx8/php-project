<?php
// src/Controller/TournamentController.php

namespace App\Controller;

use App\Entity\Tournament;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    #[Route('/tournament/{id}/generate-matches', name: 'app_generate_matches')]
    public function generateMatches(Tournament $tournament, EntityManagerInterface $em): Response
    {
        $tournament->generateEncounters($em);
        $this->addFlash('success', 'Les matchs ont été générés !');
        return $this->redirectToRoute('app_tournament_progress', ['id' => $tournament->getId()]);
    }
    
    #[Route('/tournament/{id}/advance', name: 'app_tournament_advance')]
public function advancePhase(Tournament $tournament, EntityManagerInterface $em): Response
{
    if (!$tournament->isFinished()) {
        $tournament->advancePhase($em);
        $this->addFlash('success', 'Phase avancée !');
    } else {
        $this->addFlash('warning', 'Le tournoi est déjà terminé.');
    }

    return $this->redirectToRoute('app_tournament_progress', ['id' => $tournament->getId()]);
}

}
