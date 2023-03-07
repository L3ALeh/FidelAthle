<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieCourse $uneCategorieCourse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUneCategorieCourse(): ?CategorieCourse
    {
        return $this->uneCategorieCourse;
    }

    public function setUneCategorieCourse(?CategorieCourse $uneCategorieCourse): self
    {
        $this->uneCategorieCourse = $uneCategorieCourse;

        return $this;
    }
}
