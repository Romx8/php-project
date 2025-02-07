<?php
// src/Controller/DashboardController.php

namespace App\Controller;

use App\Entity\Tournament;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        // Récupérer tous les tournois
        $tournaments = $em->getRepository(Tournament::class)->findAll();

        $user = $this->getUser();
        if ($user) {
            foreach ($tournaments as $tournament) {
                $userIsParticipant = false;
                foreach ($user->getTeamId() as $userTeam) {
                    if ($tournament->getTeams()->contains($userTeam)) {
                        $userIsParticipant = true;
                        break;
                    }
                }
                $tournament->setUserIsParticipant($userIsParticipant);
            }
        }

        return $this->render('dashboard/index.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }
}
