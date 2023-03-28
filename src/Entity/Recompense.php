<?php

namespace App\Entity;

use App\Repository\RecompenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecompenseRepository::class)]
class Recompense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?float $valeur = null;

    #[ORM\Column]
    private ?int $valeurPoints = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'lesRecompenses')]
    private Collection $lesUsers;

    public function __construct()
    {
        $this->lesUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getValeurPoints(): ?int
    {
        return $this->valeurPoints;
    }

    public function setValeurPoints(int $valeurPoints): self
    {
        $this->valeurPoints = $this->getValeur()*0.30;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLesUsers(): Collection
    {
        return $this->lesUsers;
    }

    public function addLesUser(User $lesUser): self
    {
        if (!$this->lesUsers->contains($lesUser)) {
            $this->lesUsers->add($lesUser);
            $lesUser->addLesRecompense($this);
        }

        return $this;
    }

    public function removeLesUser(User $lesUser): self
    {
        if ($this->lesUsers->removeElement($lesUser)) {
            $lesUser->removeLesRecompense($this);
        }

        return $this;
    }
}
