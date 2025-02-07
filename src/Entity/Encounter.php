<?php

namespace App\Entity;

use App\Repository\EncounterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EncounterRepository::class)]
class Encounter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    private ?Team $team1 = null;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    private ?Team $team2 = null;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    private ?Team $winner = null;

    #[ORM\ManyToOne(targetEntity: Tournament::class, inversedBy: 'encounters')]
    private ?Tournament $tournament = null;

    #[ORM\ManyToOne(targetEntity: Encounter::class)]
    private ?Encounter $nextEncounter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam1(): ?Team
    {
        return $this->team1;
    }

    public function setTeam1(?Team $team1): static
    {
        $this->team1 = $team1;
        return $this;
    }

    public function getTeam2(): ?Team
    {
        return $this->team2;
    }

    public function setTeam2(?Team $team2): static
    {
        $this->team2 = $team2;
        return $this;
    }

    public function getWinner(): ?Team
    {
        return $this->winner;
    }

    public function setWinner(?Team $winner): static
    {
        $this->winner = $winner;
        return $this;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): static
    {
        $this->tournament = $tournament;
        return $this;
    }

    public function getNextEncounter(): ?Encounter
    {
        return $this->nextEncounter;
    }

    public function setNextEncounter(?Encounter $nextEncounter): static
    {
        $this->nextEncounter = $nextEncounter;
        return $this;
    }

    // ✅ Ajouter une méthode pour récupérer les équipes participantes
    public function getTeams(): array
    {
        return array_filter([$this->team1, $this->team2]);
    }

    // ✅ Ajouter une équipe à la rencontre
    public function addTeam(Team $team): void
    {
        if (!$this->team1) {
            $this->team1 = $team;
        } elseif (!$this->team2) {
            $this->team2 = $team;
        } else {
            throw new \Exception("Cette rencontre a déjà deux équipes.");
        }
    }

    // ✅ Supprimer une équipe de la rencontre
    public function removeTeam(Team $team): void
    {
        if ($this->team1 === $team) {
            $this->team1 = null;
        } elseif ($this->team2 === $team) {
            $this->team2 = null;
        }
    }

    // ✅ Vérifier si un match est terminé (si un gagnant est défini)
    public function isFinished(): bool
    {
        return $this->winner !== null;
    }

    // ✅ Déterminer aléatoirement un gagnant et avancer la compétition
    public function determineWinner(): void
    {
        if ($this->team1 && $this->team2) {
            $this->winner = rand(0, 1) ? $this->team1 : $this->team2;
        }
    }
}
