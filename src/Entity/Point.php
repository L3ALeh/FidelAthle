<?php

namespace App\Entity;

use App\Repository\PointRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointRepository::class)]
class Point
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $leUser = null;

    #[ORM\ManyToOne]
    private ?Recompense $laRecompense = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLeUser(): ?User
    {
        return $this->leUser;
    }

    public function setLeUser(?User $leUser): self
    {
        $this->leUser = $leUser;

        return $this;
    }

    public function getLaRecompense(): ?Recompense
    {
        return $this->laRecompense;
    }

    public function setLaRecompense(?Recompense $laRecompense): self
    {
        $this->laRecompense = $laRecompense;

        return $this;
    }
}
