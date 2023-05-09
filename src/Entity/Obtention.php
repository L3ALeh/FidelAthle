<?php

namespace App\Entity;

use App\Repository\ObtentionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObtentionRepository::class)]
class Obtention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?User $unUser = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recompense $uneRecompense = null;

    #[ORM\Column]
    private ?int $quantite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnUser(): ?User
    {
        return $this->unUser;
    }

    public function setUnUser(?User $unUser): self
    {
        $this->unUser = $unUser;

        return $this;
    }

    public function getUneRecompense(): ?Recompense
    {
        return $this->uneRecompense;
    }

    public function setUneRecompense(?Recompense $uneRecompense): self
    {
        $this->uneRecompense = $uneRecompense;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
