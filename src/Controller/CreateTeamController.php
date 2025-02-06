<?php
// src/Controller/CreateTeamController.php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Tournament;
use App\Form\TeamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateTeamController extends AbstractController
{
    #[Route('/create-team', name: 'app_create_team')]
    public function createTeam(Request $request, EntityManagerInterface $em): Response
    {
         $user = $this->getUser();
         if (!$user) {
              $this->addFlash('error', 'Vous devez être connecté pour créer une équipe.');
              return $this->redirectToRoute('app_login');
         }
         
         $team = new Team();
         // Optionnel : vous pouvez associer l'utilisateur à l'équipe ici, par exemple :
         $team->addUser($user);
         
         $form = $this->createForm(TeamType::class, $team);
         $form->handleRequest($request);
         
         if ($form->isSubmitted() && $form->isValid()) {
              $em->persist($team);
              $em->flush();
              
              // Vérifier si un paramètre "tournament" est présent dans l'URL
              $tournamentId = $request->query->get('tournament');
              if ($tournamentId) {
                  $tournament = $em->getRepository(Tournament::class)->find($tournamentId);
                  if ($tournament) {
                      // Ajouter la nouvelle équipe au tournoi
                      $tournament->addTeam($team);
                      $em->persist($tournament);
                      $em->flush();
                      $this->addFlash('success', 'Votre équipe a été créée et inscrite au tournoi avec succès.');
                      return $this->redirectToRoute('app_dashboard');
                  }
              }
              
              $this->addFlash('success', 'Votre équipe a été créée avec succès.');
              return $this->redirectToRoute('app_dashboard');
         }
         
         return $this->render('create_team/index.html.twig', [
              'teamForm' => $form->createView(),
         ]);
    }
}
