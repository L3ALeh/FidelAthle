<?php

namespace App\Entity;

use App\Repository\CategorieCourseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieCourseRepository::class)]
class CategorieCourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $niveauCourse = null;

    #[ORM\Column(length: 255)]
    private ?string $typeCourse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveauCourse(): ?string
    {
        return $this->niveauCourse;
    }

    public function setNiveauCourse(string $niveauCourse): self
    {
        $this->niveauCourse = $niveauCourse;

        return $this;
    }

    public function getTypeCourse(): ?string
    {
        return $this->typeCourse;
    }

    public function setTypeCourse(string $typeCourse): self
    {
        $this->typeCourse = $typeCourse;

        return $this;
    }
}
