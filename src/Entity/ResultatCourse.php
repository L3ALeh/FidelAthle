<?php

namespace App\Entity;

use App\Repository\ResultatCourseRepository;
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

    #[ORM\ManyToOne]
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
