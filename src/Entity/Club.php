<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
class Club
{
    #[ORM\Id]
    #[ORM\Column(name:'ref')]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToMany(targetEntity: Student::class, mappedBy: 'clubs')]
   
    private Collection $studentsClubs;

    public function __construct()
    {
        $this->studentsClubs = new ArrayCollection();
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
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudentsClubs(): Collection
    {
        return $this->studentsClubs;
    }

    public function addStudentsClub(Student $studentsClub): self
    {
        if (!$this->studentsClubs->contains($studentsClub)) {
            $this->studentsClubs->add($studentsClub);
            $studentsClub->addClub($this);
        }

        return $this;
    }

    public function removeStudentsClub(Student $studentsClub): self
    {
        if ($this->studentsClubs->removeElement($studentsClub)) {
            $studentsClub->removeClub($this);
        }

        return $this;
    }
}
