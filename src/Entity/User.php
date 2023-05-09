<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
/**
 * Summary of User
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\OneToMany(mappedBy: 'leUser', targetEntity: ResultatCourse::class)]
    private Collection $lesResultatsCourses;

    #[ORM\Column]
    private ?int $nombreDePoints = null;

    #[ORM\Column]
    private ?bool $estOrganisateur = null;

    #[ORM\OneToMany(mappedBy: 'unOrganisateur', targetEntity: Course::class)]
    private Collection $lesCoursesOrganisees;

    public function __construct()
    {
        $this->lesResultatsCourses = new ArrayCollection();
        $this->lesCoursesOrganisees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

     /** 
     * @return Collection<int, ResultatCourse>
     */
    public function getLesResultatsCourses(): Collection
    {
        return $this->lesResultatsCourses;
    }

    public function addLesResultatsCourse(ResultatCourse $lesResultatsCourse): self
    {
        if (!$this->lesResultatsCourses->contains($lesResultatsCourse)) {
            $this->lesResultatsCourses->add($lesResultatsCourse);
            $lesResultatsCourse->setLeUser($this);
        }

        return $this;
    }
   
    public function removeLesResultatsCourse(ResultatCourse $lesResultatsCourse): self
    {
        if ($this->lesResultatsCourses->removeElement($lesResultatsCourse)) {
            // set the owning side to null (unless already changed)
            if ($lesResultatsCourse->getLeUser() === $this) {
                $lesResultatsCourse->setLeUser(null);
            }
        }

        return $this;
    }

    public function getNombreDePoints(): ?int
    {
        return $this->nombreDePoints;
    }

    public function setNombreDePoints(int $nombreDePoints): self
    {
        $this->nombreDePoints = $nombreDePoints;

        return $this;
    }

    public function isEstOrganisateur(): ?bool
    {
        return $this->estOrganisateur;
    }

    public function setEstOrganisateur(bool $estOrganisateur): self
    {
        $this->estOrganisateur = $estOrganisateur;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getLesCoursesOrganisees(): Collection
    {
        return $this->lesCoursesOrganisees;
    }

    public function addLesCoursesOrganisee(Course $lesCoursesOrganisee): self
    {
        if (!$this->lesCoursesOrganisees->contains($lesCoursesOrganisee)) {
            $this->lesCoursesOrganisees->add($lesCoursesOrganisee);
            $lesCoursesOrganisee->setUnOrganisateur($this);
        }

        return $this;
    }

    public function removeLesCoursesOrganisee(Course $lesCoursesOrganisee): self
    {
        if ($this->lesCoursesOrganisees->removeElement($lesCoursesOrganisee)) {
            // set the owning side to null (unless already changed)
            if ($lesCoursesOrganisee->getUnOrganisateur() === $this) {
                $lesCoursesOrganisee->setUnOrganisateur(null);
            }
        }

        return $this;
    }
}
