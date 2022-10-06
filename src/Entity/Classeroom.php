<?php

namespace App\Entity;

use App\Repository\ClasseroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseroomRepository::class)]
class Classeroom
{
    #[ORM\OneToMany(mappedBy: 'classrooms', targetEntity: Student::class,
     cascade: ["persist", "remove", "merge"],
    orphanRemoval: true
    )]
    private Collection $studentsClass;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

  

    public function __construct()
    {
        $this->studentsClass = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Student>
     */
    public function getStudentsClass(): Collection
    {
        return $this->studentsClass;
    }

    public function addStudentsClass(Student $studentsClass): self
    {
        if (!$this->studentsClass->contains($studentsClass)) {
            $this->studentsClass->add($studentsClass);
            $studentsClass->setClassrooms($this);
        }

        return $this;
    }

    public function removeStudentsClass(Student $studentsClass): self
    {
        if ($this->studentsClass->removeElement($studentsClass)) {
            // set the owning side to null (unless already changed)
            if ($studentsClass->getClassrooms() === $this) {
                $studentsClass->setClassrooms(null);
            }
        }

        return $this;
    }
}
