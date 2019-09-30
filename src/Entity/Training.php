<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingRepository")
 */
class Training
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\Column(type="time")
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userTraining")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ListMove", inversedBy="trainings")
     */
    private $selectMove;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groupe", inversedBy="trainings")
     */
    private $groupe;

    public function __construct()
    {
        $this->selectMove = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|ListMove[]
     */
    public function getSelectMove(): Collection
    {
        return $this->selectMove;
    }

    public function addSelectMove(ListMove $selectMove): self
    {
        if (!$this->selectMove->contains($selectMove)) {
            $this->selectMove[] = $selectMove;
        }

        return $this;
    }

    public function removeSelectMove(ListMove $selectMove): self
    {
        if ($this->selectMove->contains($selectMove)) {
            $this->selectMove->removeElement($selectMove);
        }

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }
}
