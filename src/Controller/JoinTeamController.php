<?php
// src/Controller/JoinTeamController.php

namespace App\Controller;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JoinTeamController extends AbstractController
{
    #[Route('/join-team/{id}', name: 'app_join_team')]
    public function joinTeam(Team $team, EntityManagerInterface $em): Response
    {
        // Vérifier que l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour rejoindre une équipe.');
            return $this->redirectToRoute('app_login');
        }
        
        // Vérifier si l'utilisateur est déjà membre de l'équipe
        if ($team->getUser()->contains($user)) {
            $this->addFlash('info', 'Vous êtes déjà membre de cette équipe.');
            return $this->redirectToRoute('app_team_list');
        }
        
        // Optionnel : Vérifier que l'équipe n'est pas pleine
        if ($team->getUser()->count() >= $team->getNbMaxUser()) {
            $this->addFlash('error', 'Cette équipe est pleine.');
            return $this->redirectToRoute('app_team_list');
        }
        
        // Ajouter l'utilisateur à l'équipe
        $team->addUser($user);
        $em->persist($team);
        $em->flush();
        
        $this->addFlash('success', 'Vous avez rejoint l\'équipe avec succès.');
        return $this->redirectToRoute('app_team_list');
    }
}
