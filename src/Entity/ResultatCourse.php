<?php

namespace App\Entity;

use App\Repository\ResultatCourseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatCourseRepository::class)]
class ResultatCourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $uneCourse = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $temps = null;

    #[ORM\Column (nullable: true)]
    private ?float $vitesseMoyenne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $position = null;

    #[ORM\ManyToOne(inversedBy: 'lesResultatsCourses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $leUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUneCourse(): ?Course
    {
        return $this->uneCourse;
    }

    public function setUneCourse(?Course $uneCourse): self
    {
        $this->uneCourse = $uneCourse;

        return $this;
    }

    public function getTemps(): ?\DateTimeInterface
    {
        return $this->temps;
    }

    public function setTemps(\DateTimeInterface $temps): self
    {
        $this->temps = $temps;

        return $this;
    }

    public function getVitesseMoyenne(): ?float
    {
        return $this->vitesseMoyenne;
    }

    public function setVitesseMoyenne(float $vitesseMoyenne): self
    {
        $this->vitesseMoyenne = $vitesseMoyenne;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
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
}
