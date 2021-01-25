<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^0[0-9]{9}$/")
     * @Assert\Length(min=10)
     * @Assert\Length(max=10)
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/[A-Z]/", message="Huit caractères au minimum, au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial")
     * @Assert\Regex("/[a-z]/", message="Huit caractères au minimum, au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial")
     * @Assert\Regex("/[0-9]/", message="Huit caractères au minimum, au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial")
     * @Assert\Length(min=10)
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partie", mappedBy="user")
     */
    private $partie;

    public function __construct()
    {
        //$this->movies = new ArrayCollection();
        $this->roles = array ('ROLE_USER');
    }


    public function getFirstname(): ?string
    {
        return $this->prenom;
    }

    public function setFirstname(string $prenom): self
    {
        $this->firstname = $prenom;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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
    
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
    }
    public function getSalt()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    public function getUsername()
    {
        return $this->prenom;
    }

    /**
     * @return mixed
     */
    public function getPartie()
    {
        return $this->partie;
    }

    /**
     * @param mixed $partie
     */
    public function setPartie($partie): void
    {
        $this->partie = $partie;
    }

    /**
     * @return Collection|Partie[]
     */
    public function getArticles(): Collection
    {
        return $this->partie;
    }

    public function addPartie(Partie $partie): self
    {
        if (!$this->partie->contains($partie)) {
            $this->partie[] = $partie;
            $partie->setUser($this);
        }

        return $this;
    }
    public function removePartie(Partie $partie): self
    {
        if ($this->partie->contains($partie)) {
            $this->partie->removeElement($partie);
            // set the owning side to null (unless already changed)
            if ($partie->getUser() === $this) {
                $partie->setUser(null);
            }
        }

        return $this;
    }
}

