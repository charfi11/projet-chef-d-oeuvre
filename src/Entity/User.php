<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields= {"username"},
 * message= "Le pseudo que vous avez indiqué est déjà utilisé"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

       /**
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapez le même mot de passe")
     */
    public $confirmPass;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Training", mappedBy="user", cascade={"persist","remove"})
     */
    private $userTraining;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="user", cascade={"persist","remove"})
     */
    private $userEvent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Groupe", inversedBy="users")
     */
    private $GroupePart;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Roles", mappedBy="role_user")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Groupe", mappedBy="user", orphanRemoval=true)
     */
    private $moderateur;

    public function __construct()
    {
        $this->userTraining = new ArrayCollection();
        $this->userEvent = new ArrayCollection();
        $this->GroupePart = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->moderateur = new ArrayCollection();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function getAvatarName()
    {
        return $this->username.''.$this->id;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection|Training[]
     */
    public function getUserTraining(): Collection
    {
        return $this->userTraining;
    }

    public function addUserTraining(Training $userTraining): self
    {
        if (!$this->userTraining->contains($userTraining)) {
            $this->userTraining[] = $userTraining;
            $userTraining->setUser($this);
        }

        return $this;
    }

    public function removeUserTraining(Training $userTraining): self
    {
        if ($this->userTraining->contains($userTraining)) {
            $this->userTraining->removeElement($userTraining);
            // set the owning side to null (unless already changed)
            if ($userTraining->getUser() === $this) {
                $userTraining->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getUserEvent(): Collection
    {
        return $this->userEvent;
    }

    public function addUserEvent(Event $userEvent): self
    {
        if (!$this->userEvent->contains($userEvent)) {
            $this->userEvent[] = $userEvent;
            $userEvent->setUser($this);
        }

        return $this;
    }

    public function removeUserEvent(Event $userEvent): self
    {
        if ($this->userEvent->contains($userEvent)) {
            $this->userEvent->removeElement($userEvent);
            // set the owning side to null (unless already changed)
            if ($userEvent->getUser() === $this) {
                $userEvent->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupePart(): Collection
    {
        return $this->GroupePart;
    }

    public function addGroupePart(Groupe $groupePart): self
    {
        if (!$this->GroupePart->contains($groupePart)) {
            $this->GroupePart[] = $groupePart;
        }

        return $this;
    }

    public function removeGroupePart(Groupe $groupePart): self
    {
        if ($this->GroupePart->contains($groupePart)) {
            $this->GroupePart->removeElement($groupePart);
        }

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection|Roles[]
     */
    public function getRoles()
    {
        $roles = $this->roles->map(function($role){
            return $role->getTitle();
        })->toArray();
        $roles[] = 'ROLE_USER';
        return $roles;
    }

    public function addRole(Roles $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addRoleUser($this);
        }

        return $this;
    }

    public function removeRole(Roles $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
            $role->removeRoleUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getModerateur(): Collection
    {
        return $this->moderateur;
    }

    public function addModerateur(Groupe $moderateur): self
    {
        if (!$this->moderateur->contains($moderateur)) {
            $this->moderateur[] = $moderateur;
            $moderateur->setUser($this);
        }

        return $this;
    }

    public function removeModerateur(Groupe $moderateur): self
    {
        if ($this->moderateur->contains($moderateur)) {
            $this->moderateur->removeElement($moderateur);
            // set the owning side to null (unless already changed)
            if ($moderateur->getUser() === $this) {
                $moderateur->setUser(null);
            }
        }

        return $this;
    }
}
