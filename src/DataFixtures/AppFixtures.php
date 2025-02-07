<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Team;
use App\Entity\Tournament;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création des utilisateurs
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setPseudo($faker->userName);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $manager->persist($user);
            $users[] = $user;
        }

        // Création des équipes
        $teams = [];
        for ($i = 0; $i < 5; $i++) {
            $team = new Team();
            $team->setName($faker->word . ' Team');
            $team->setNbMaxUser($faker->numberBetween(3, 10));

            // Ajouter des utilisateurs à l'équipe
            $randomUsers = $faker->randomElements($users, $faker->numberBetween(1, 5));
            foreach ($randomUsers as $user) {
                $team->addUser($user);
            }

            $manager->persist($team);
            $teams[] = $team;
        }

        // Création des tournois
        for ($i = 0; $i < 5; $i++) {
            $tournament = new Tournament();
            $tournament->setName('Tournoi ' . $faker->word);
            $tournament->setDescription($faker->sentence);
            $tournament->setCashprice($faker->numberBetween(100, 5000));
            $tournament->setNbMaxTeam($faker->numberBetween(4, 16));
            $tournament->setDate($faker->dateTimeBetween('-1 months', '+3 months'));
            $tournament->setFinished($faker->boolean);
            $tournament->setStartInscription($faker->dateTimeBetween('-2 months', 'now'));
            $tournament->setEndInscription($faker->dateTimeBetween('now', '+1 months'));

            // Ajouter des équipes au tournoi
            $randomTeams = $faker->randomElements($teams, $faker->numberBetween(2, 5));
            foreach ($randomTeams as $team) {
                $tournament->addTeam($team);
            }

            $manager->persist($tournament);
        }

        $manager->flush();
    }
}
