<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListMoveRepository")
 */
class ListMove
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $resume;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $tutoriel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $difficulte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieMove", inversedBy="listMoves")
     */
    private $typeMove;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Training", mappedBy="selectMove")
     */
    private $trainings;

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
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

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getTutoriel(): ?string
    {
        return $this->tutoriel;
    }

    public function setTutoriel(string $tutoriel): self
    {
        $this->tutoriel = $tutoriel;

        return $this;
    }

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(string $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getTypeMove(): ?CategorieMove
    {
        return $this->typeMove;
    }

    public function setTypeMove(?CategorieMove $typeMove): self
    {
        $this->typeMove = $typeMove;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->addSelectMove($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->contains($training)) {
            $this->trainings->removeElement($training);
            $training->removeSelectMove($this);
        }

        return $this;
    }
}
