<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCourse = null;

    #[ORM\Column]
    private ?float $distance = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?NiveauCourse $unNiveauCourse = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeCourse $unTypeCourse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCourse(): ?string
    {
        return $this->nomCourse;
    }

    public function setNomCourse(string $nomCourse): self
    {
        $this->nomCourse = $nomCourse;

        return $this;
    }

    public function getDistance(): ?float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUnNiveauCourse(): ?NiveauCourse
    {
        return $this->unNiveauCourse;
    }

    public function setUnNiveauCourse(?NiveauCourse $unNiveauCourse): self
    {
        $this->unNiveauCourse = $unNiveauCourse;

        return $this;
    }

    public function getUnTypeCourse(): ?TypeCourse
    {
        return $this->unTypeCourse;
    }

    public function setUnTypeCourse(?TypeCourse $unTypeCourse): self
    {
        $this->unTypeCourse = $unTypeCourse;

        return $this;
    }
}
