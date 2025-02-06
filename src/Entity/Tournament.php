<?php

namespace App\Entity;

use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
    private ?bool $finished = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_inscription = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_inscription = null;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'TournamentId')]
    private Collection $Team;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\OneToMany(targetEntity: Team::class, mappedBy: 'TournamentWinId')]
    private Collection $winer;

    #[ORM\ManyToOne(inversedBy: 'Tournament')]
    private ?Encounter $EcounterId = null;

    // Propriété non persistée pour indiquer si l'utilisateur participe
    private bool $userIsParticipant = false;

    public function __construct()
    {
        $this->Team = new ArrayCollection();
        $this->winer = new ArrayCollection();
    }

    // --- Getters et setters pour les propriétés persistées ---

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

    /**
     * @return Collection<int, Team>
     */
    public function getTeam(): Collection
    {
        return $this->Team;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->Team->contains($team)) {
            $this->Team->add($team);
        }
        return $this;
    }

    public function removeTeam(Team $team): static
    {
        $this->Team->removeElement($team);
        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getWiner(): Collection
    {
        return $this->winer;
    }

    public function addWiner(Team $winer): static
    {
        if (!$this->winer->contains($winer)) {
            $this->winer->add($winer);
            $winer->setTournamentWinId($this);
        }
        return $this;
    }

    public function removeWiner(Team $winer): static
    {
        if ($this->winer->removeElement($winer)) {
            if ($winer->getTournamentWinId() === $this) {
                $winer->setTournamentWinId(null);
            }
        }
        return $this;
    }

    public function getEcounterId(): ?Encounter
    {
        return $this->EcounterId;
    }

    public function setEcounterId(?Encounter $EcounterId): static
    {
        $this->EcounterId = $EcounterId;
        return $this;
    }

    // --- Propriété non persistée : userIsParticipant ---

    public function getUserIsParticipant(): bool
    {
        return $this->userIsParticipant;
    }

    public function setUserIsParticipant(bool $userIsParticipant): self
    {
        $this->userIsParticipant = $userIsParticipant;
        return $this;
    }
}
