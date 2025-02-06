<?php
// src/Controller/TeamListController.php

namespace App\Controller;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamListController extends AbstractController
{
    #[Route('/teams', name: 'app_team_list')]
    public function list(EntityManagerInterface $em): Response
    {
        // Récupère toutes les équipes
        $teams = $em->getRepository(Team::class)->findAll();

        // Récupère l'utilisateur connecté
        $user = $this->getUser();
        $userTeams = [];

        if ($user) {
            // Pour chaque équipe, vérifiez si l'utilisateur y figure dans la collection "User"
            foreach ($teams as $team) {
                if ($team->getUser()->contains($user)) {
                    $userTeams[] = $team;
                }
            }
        }

        return $this->render('team_list/index.html.twig', [
            'teams' => $teams,
            'userTeams' => $userTeams,
        ]);
    }
}
