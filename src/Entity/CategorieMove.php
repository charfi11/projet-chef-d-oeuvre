<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieMoveRepository")
 */
class CategorieMove
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
     * @ORM\OneToMany(targetEntity="App\Entity\ListMove", mappedBy="typeMove")
     */
    private $listMoves;

    public function __construct()
    {
        $this->listMoves = new ArrayCollection();
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
     * @return Collection|ListMove[]
     */
    public function getListMoves(): Collection
    {
        return $this->listMoves;
    }

    public function addListMove(ListMove $listMove): self
    {
        if (!$this->listMoves->contains($listMove)) {
            $this->listMoves[] = $listMove;
            $listMove->setTypeMove($this);
        }

        return $this;
    }

    public function removeListMove(ListMove $listMove): self
    {
        if ($this->listMoves->contains($listMove)) {
            $this->listMoves->removeElement($listMove);
            // set the owning side to null (unless already changed)
            if ($listMove->getTypeMove() === $this) {
                $listMove->setTypeMove(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
