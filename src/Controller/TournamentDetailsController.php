<?php
// src/Controller/TournamentDetailsController.php

namespace App\Controller;

use App\Entity\Tournament;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentDetailsController extends AbstractController
{
    #[Route('/tournament/{id}', name: 'app_tournament_details')]
    public function details(Tournament $tournament): Response
    {
        return $this->render('tournament_details/index.html.twig', [
            'tournament' => $tournament,
        ]);
    }
}
