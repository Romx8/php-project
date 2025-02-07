<?php

namespace App\Entity;

use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;

#[ORM\Entity(repositoryClass: TournamentRepository::class)]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $cashprice = null;

    #[ORM\Column]
    private ?int $nbMaxTeam = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?bool $finished = false;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_inscription = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_inscription = null;

    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'TournamentId')]
    private Collection $teams;

    #[ORM\OneToMany(targetEntity: Encounter::class, mappedBy: 'tournament', cascade: ['remove'])]
    private Collection $encounters;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    private ?Team $winner = null;

    private bool $userIsParticipant = false;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->encounters = new ArrayCollection();
    }

    // --- Getters & Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getCashprice(): ?int
    {
        return $this->cashprice;
    }

    public function setCashprice(int $cashprice): static
    {
        $this->cashprice = $cashprice;
        return $this;
    }

    public function getNbMaxTeam(): ?int
    {
        return $this->nbMaxTeam;
    }

    public function setNbMaxTeam(int $nbMaxTeam): static
    {
        $this->nbMaxTeam = $nbMaxTeam;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function isFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): static
    {
        $this->finished = $finished;
        return $this;
    }

    public function getStartInscription(): ?\DateTimeInterface
    {
        return $this->start_inscription;
    }

    public function setStartInscription(\DateTimeInterface $start_inscription): static
    {
        $this->start_inscription = $start_inscription;
        return $this;
    }

    public function getEndInscription(): ?\DateTimeInterface
    {
        return $this->end_inscription;
    }

    public function setEndInscription(\DateTimeInterface $end_inscription): static
    {
        $this->end_inscription = $end_inscription;
        return $this;
    }

    // Gestion des équipes inscrites
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
        }
        return $this;
    }

    public function removeTeam(Team $team): static
    {
        $this->teams->removeElement($team);
        return $this;
    }

    // Gestion des matchs (Encounters)
    public function getEncounters(): Collection
    {
        return $this->encounters;
    }

    public function addEncounter(Encounter $encounter): static
    {
        if (!$this->encounters->contains($encounter)) {
            $this->encounters->add($encounter);
            $encounter->setTournament($this);
        }
        return $this;
    }

    public function removeEncounter(Encounter $encounter): static
    {
        $this->encounters->removeElement($encounter);
        return $this;
    }

    // Gagnant du tournoi
    public function getWinner(): ?Team
    {
        return $this->winner;
    }

    public function setWinner(?Team $winner): static
    {
        $this->winner = $winner;
        return $this;
    }

    // Gestion des participants
    public function getUserIsParticipant(): bool
    {
        return $this->userIsParticipant;
    }

    public function setUserIsParticipant(bool $userIsParticipant): self
    {
        $this->userIsParticipant = $userIsParticipant;
        return $this;
    }

    // --- Logique des matchs ---

    public function generateEncounters(EntityManagerInterface $em)
    {
        $teams = $this->getTeams()->toArray();
        shuffle($teams); // Mélanger aléatoirement les équipes

        $matchCount = floor(count($teams) / 2); // Nombre de matchs (paire d’équipes)

        for ($i = 0; $i < $matchCount; $i++) {
            $match = new Encounter();
            $match->setTournament($this);
            $match->setTeam1($teams[$i * 2]);
            $match->setTeam2($teams[$i * 2 + 1]);

            $em->persist($match);
        }

        $em->flush();
    }

    public function advancePhase(EntityManagerInterface $em)
{
    $matches = $this->getEncounters()->toArray(); // Récupère tous les matchs du tournoi

    if (count($matches) == 1) {
        // 🏆 Dernier match, définir le gagnant du tournoi
        $finalMatch = $matches[0];
        $winner = rand(0, 1) ? $finalMatch->getTeam1() : $finalMatch->getTeam2();
        $this->setWinner($winner);
        $this->setFinished(true);
    } else {
        $newMatches = [];
        shuffle($matches); // Mélange les matchs pour rendre aléatoire

        for ($i = 0; $i < count($matches); $i += 2) {
            if (!isset($matches[$i + 1])) break; // Éviter les erreurs s'il reste un match impair

            $match1 = $matches[$i];
            $match2 = $matches[$i + 1];

            // Sélectionner un gagnant aléatoire pour chaque match
            $winner1 = rand(0, 1) ? $match1->getTeam1() : $match1->getTeam2();
            $winner2 = rand(0, 1) ? $match2->getTeam1() : $match2->getTeam2();

            // Créer un nouveau match avec les gagnants
            $newMatch = new Encounter();
            $newMatch->setTournament($this);
            $newMatch->setTeam1($winner1);
            $newMatch->setTeam2($winner2);

            $em->persist($newMatch);
            $newMatches[] = $newMatch;
        }

        // Supprimer les anciens matchs terminés
        foreach ($matches as $match) {
            $em->remove($match);
        }
    }

    $em->flush();
}

}
