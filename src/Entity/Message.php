<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $mess;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groupe", inversedBy="messages")
     */
    private $messGroupe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMess(): ?string
    {
        return $this->mess;
    }

    public function setMess(string $mess): self
    {
        $this->mess = $mess;

        return $this;
    }

    public function getMessGroupe(): ?Groupe
    {
        return $this->messGroupe;
    }

    public function setMessGroupe(?Groupe $messGroupe): self
    {
        $this->messGroupe = $messGroupe;

        return $this;
    }
}
