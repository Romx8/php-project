<?php

namespace App\Entity;

use App\Repository\EncounterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EncounterRepository::class)]
class Encounter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $result = null;

    /**
     * @var Collection<int, Tournament>
     */
    #[ORM\OneToMany(targetEntity: Tournament::class, mappedBy: 'EcounterId')]
    private Collection $Tournament;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'EncounterId')]
    private Collection $Team;

    public function __construct()
    {
        $this->Tournament = new ArrayCollection();
        $this->Team = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isResult(): ?bool
    {
        return $this->result;
    }

    public function setResult(bool $result): static
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return Collection<int, Tournament>
     */
    public function getTournament(): Collection
    {
        return $this->Tournament;
    }

    public function addTournament(Tournament $tournament): static
    {
        if (!$this->Tournament->contains($tournament)) {
            $this->Tournament->add($tournament);
            $tournament->setEcounterId($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): static
    {
        if ($this->Tournament->removeElement($tournament)) {
            // set the owning side to null (unless already changed)
            if ($tournament->getEcounterId() === $this) {
                $tournament->setEcounterId(null);
            }
        }

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
}
