<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
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
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieEvent", inversedBy="events")
     */
    private $typeEvent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userEvent")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groupe", inversedBy="events")
     */
    private $eventgroupe;

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getTypeEvent(): ?CategorieEvent
    {
        return $this->typeEvent;
    }

    public function setTypeEvent(?CategorieEvent $typeEvent): self
    {
        $this->typeEvent = $typeEvent;

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

    public function getEventgroupe(): ?Groupe
    {
        return $this->eventgroupe;
    }

    public function setEventgroupe(?Groupe $eventgroupe): self
    {
        $this->eventgroupe = $eventgroupe;

        return $this;
    }
}
