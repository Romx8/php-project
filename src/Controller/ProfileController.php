<?php
// src/Controller/ProfileController.php

namespace App\Controller;

use App\Form\ProfileType;
use App\Entity\Tournament;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Création et gestion du formulaire de profil
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Profil mis à jour.');
            return $this->redirectToRoute('app_profile');
        }

        // Récupérer tous les tournois (vous pouvez ajuster la requête selon vos besoins)
        $allTournaments = $em->getRepository(Tournament::class)->findAll();

        // Initialisation des tableaux de tournois
        $registeredTournaments = [];
        $participatedTournaments = [];

        // Récupération des équipes de l'utilisateur
        $userTeams = $user->getTeamId(); // Assurez-vous que cette méthode retourne une Collection d'objets Team

        // Pour chaque tournoi, déterminer si l'utilisateur y est inscrit
        foreach ($allTournaments as $tournament) {
            $isRegistered = false;
            foreach ($userTeams as $team) {
                // Si l'une des équipes de l'utilisateur est inscrite dans le tournoi
                if ($tournament->getTeam()->contains($team)) {
                    $isRegistered = true;
                    break;
                }
            }
            if ($isRegistered) {
                if ($tournament->isFinished()) {
                    $participatedTournaments[] = $tournament;
                } else {
                    $registeredTournaments[] = $tournament;
                }
            }
        }

        return $this->render('profile/index.html.twig', [
            'profileForm' => $form->createView(),
            'registeredTournaments' => $registeredTournaments,
            'participatedTournaments' => $participatedTournaments,
        ]);
    }
}
