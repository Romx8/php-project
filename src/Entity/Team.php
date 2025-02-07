<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $nbMaxUser = null;

    /**
     * @var Collection<int, Tournament>
     */
    #[ORM\ManyToMany(targetEntity: Tournament::class, mappedBy: 'Team')]
    private Collection $TournamentId;

    #[ORM\ManyToOne(inversedBy: 'winer')]
    private ?Tournament $TournamentWinId = null;

    /**
     * @var Collection<int, Encounter>
     */
    #[ORM\ManyToMany(targetEntity: Encounter::class, mappedBy: 'Team')]
    private Collection $EncounterId;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'TeamId')]
    private Collection $User;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'TeamLeaderId')]
    private Collection $leaderId;

    public function __construct()
    {
        $this->TournamentId = new ArrayCollection();
        $this->EncounterId = new ArrayCollection();
        $this->User = new ArrayCollection();
        $this->leaderId = new ArrayCollection();
    }

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

    public function getNbMaxUser(): ?int
    {
        return $this->nbMaxUser;
    }

    public function setNbMaxUser(int $nbMaxUser): static
    {
        $this->nbMaxUser = $nbMaxUser;

        return $this;
    }

    /**
     * @return Collection<int, Tournament>
     */
    public function getTournamentId(): Collection
    {
        return $this->TournamentId;
    }

    public function addTournamentId(Tournament $tournamentId): static
    {
        if (!$this->TournamentId->contains($tournamentId)) {
            $this->TournamentId->add($tournamentId);
            $tournamentId->addTeam($this);
        }

        return $this;
    }

    public function removeTournamentId(Tournament $tournamentId): static
    {
        if ($this->TournamentId->removeElement($tournamentId)) {
            $tournamentId->removeTeam($this);
        }

        return $this;
    }

    public function getTournamentWinId(): ?Tournament
    {
        return $this->TournamentWinId;
    }

    public function setTournamentWinId(?Tournament $TournamentWinId): static
    {
        $this->TournamentWinId = $TournamentWinId;

        return $this;
    }

    /**
     * @return Collection<int, Encounter>
     */
    public function getEncounterId(): Collection
    {
        return $this->EncounterId;
    }

    public function addEncounterId(Encounter $encounterId): static
    {
        if (!$this->EncounterId->contains($encounterId)) {
            $this->EncounterId->add($encounterId);
            $encounterId->addTeam($this);
        }

        return $this;
    }

    public function removeEncounterId(Encounter $encounterId): static
    {
        if ($this->EncounterId->removeElement($encounterId)) {
            $encounterId->removeTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): static
    {
        if (!$this->User->contains($user)) {
            $this->User->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->User->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLeaderId(): Collection
    {
        return $this->leaderId;
    }

    public function addLeaderId(User $leaderId): static
    {
        if (!$this->leaderId->contains($leaderId)) {
            $this->leaderId->add($leaderId);
            $leaderId->setTeamLeaderId($this);
        }

        return $this;
    }

    public function removeLeaderId(User $leaderId): static
    {
        if ($this->leaderId->removeElement($leaderId)) {
            // set the owning side to null (unless already changed)
            if ($leaderId->getTeamLeaderId() === $this) {
                $leaderId->setTeamLeaderId(null);
            }
        }

        return $this;
    }
}
