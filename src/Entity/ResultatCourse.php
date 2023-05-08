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

    #[ORM\Column(nullable: true)]
    private ?string $temps = null;

    #[ORM\Column (nullable: true)]
    private ?float $vitesseMoyenne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $position = null;

    #[ORM\ManyToOne(inversedBy: 'lesResultatsCourses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $leUser = null;

    #[ORM\ManyToOne(inversedBy: 'lesResultatsCourses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $uneCourse = null;

    #[ORM\Column]
    private ?bool $classementDefinitif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemps(): ?string
    {
        return $this->temps;
    }

    public function setTemps(string $temps): self
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

    public function getUneCourse(): ?Course
    {
        return $this->uneCourse;
    }

    public function setUneCourse(?Course $uneCourse): self
    {
        $this->uneCourse = $uneCourse;

        return $this;
    }

    public function isClassementDefinitif(): ?bool
    {
        return $this->classementDefinitif;
    }

    public function setClassementDefinitif(bool $classementDefinitif): self
    {
        $this->classementDefinitif = $classementDefinitif;

        return $this;
    }
}
