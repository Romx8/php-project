<?php
// src/Controller/TournamentProgressController.php

namespace App\Controller;

use App\Entity\Tournament;
use App\Entity\Encounter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentProgressController extends AbstractController
{
    #[Route('/tournament/{id}/progress', name: 'app_tournament_progress')]
    public function showProgress(Tournament $tournament, EntityManagerInterface $em): Response
    {
        // Récupérer tous les matchs du tournoi
        $encounters = $em->getRepository(Encounter::class)
                         ->findBy(['tournament' => $tournament]);

        // Construire la structure de l'arbre à partir des matchs
        $tree = $this->buildTournamentTree($encounters);

        return $this->render('tournament_progress/index.html.twig', [
            'tournament' => $tournament,
            'tree' => $tree
        ]);
    }

    private function buildTournamentTree(array $encounters): array
    {
        $tree = [];
        foreach ($encounters as $encounter) {
            $tree[$encounter->getId()] = [
                'id' => $encounter->getId(),
                'team1' => $encounter->getTeam1() ? $encounter->getTeam1()->getName() : 'TBD',
                'team2' => $encounter->getTeam2() ? $encounter->getTeam2()->getName() : 'TBD',
                'winner' => $encounter->getWinner() ? $encounter->getWinner()->getName() : null,
                'nextEncounter' => $encounter->getNextEncounter() ? $encounter->getNextEncounter()->getId() : null
            ];
        }
        return $tree;
    }
}
