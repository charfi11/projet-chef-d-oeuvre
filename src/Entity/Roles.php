<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RolesRepository")
 */
class Roles
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
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="roles")
     */
    private $role_user;

    public function __construct()
    {
        $this->role_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getRoleUser(): Collection
    {
        return $this->role_user;
    }

    public function addRoleUser(User $roleUser): self
    {
        if (!$this->role_user->contains($roleUser)) {
            $this->role_user[] = $roleUser;
        }

        return $this;
    }

    public function removeRoleUser(User $roleUser): self
    {
        if ($this->role_user->contains($roleUser)) {
            $this->role_user->removeElement($roleUser);
        }

        return $this;
    }
}
