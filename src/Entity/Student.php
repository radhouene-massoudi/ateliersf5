<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumns;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\Column(name:'nsc')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'studentsClass')]
    private ?Classeroom $classrooms = null;





    #[ORM\ManyToMany(targetEntity: Club::class, inversedBy: 'studentsClubs')]
    #[ORM\JoinTable(name:'student_club')]
    #[ORM\JoinColumn(name: "student_id", referencedColumnName: "nsc")]
    #[ORM\InverseJoinColumn(name: "club_id", referencedColumnName: "ref")]
    private Collection $clubs;

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId( $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getClassrooms(): ?Classeroom
    {
        return $this->classrooms;
    }

    public function setClassrooms(?Classeroom $classrooms): self
    {
        $this->classrooms = $classrooms;

        return $this;
    }

    /**
     * @return Collection<int, Club>
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(Club $club): self
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs->add($club);
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        $this->clubs->removeElement($club);

        return $this;
    }
}
