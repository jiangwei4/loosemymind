<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @UniqueEntity("codeActivation")
 * @ORM\Entity(repositoryClass=PartieRepository::class)
 */
class Partie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nomDeLaPartie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $codeActivation;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive 
     */
    private $nombreDeJoueurxMaximum;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="partie")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EscapeGame", inversedBy="partie")
     * @ORM\JoinColumn(nullable=true)
     */
    private $escapeGame;

    /**
     * @ORM\Column(type="integer")
     */
    private $fini;

    /**
     * @ORM\Column(type="integer")
     */
    private $positionDansLaPartie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDeDebut;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDeLaPartie(): ?string
    {
        return $this->nomDeLaPartie;
    }

    public function setNomDeLaPartie(string $nomDeLaPartie): self
    {
        $this->nomDeLaPartie = $nomDeLaPartie;

        return $this;
    }

    public function getCodeActivation(): ?string
    {
        return $this->codeActivation;
    }

    public function setCodeActivation(string $codeActivation): self
    {
        $this->codeActivation = $codeActivation;

        return $this;
    }

    public function getNombreDeJoueurxMaximum(): ?int
    {
        return $this->nombreDeJoueurxMaximum;
    }

    public function setNombreDeJoueurxMaximum(int $nombreDeJoueurxMaximum): self
    {
        $this->nombreDeJoueurxMaximum = $nombreDeJoueurxMaximum;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->users;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEscapeGame(): ?EscapeGame
    {
        return $this->escapeGame;
    }

    public function setEscapeGame(?EscapeGame $escapeGame): self
    {
        $this->escapeGame = $escapeGame;

        return $this;
    }

    public function getFini(): ?int
    {
        return $this->fini;
    }

    public function setFini(int $fini): self
    {
        $this->fini = $fini;

        return $this;
    }

    public function getPositionDansLaPartie(): ?int
    {
        return $this->positionDansLaPartie;
    }

    public function setPositionDansLaPartie(int $positionDansLaPartie): self
    {
        $this->positionDansLaPartie = $positionDansLaPartie;

        return $this;
    }

    public function getDateDeDebut(): ?\DateTimeInterface
    {
        return $this->dateDeDebut;
    }

    public function setDateDeDebut(\DateTimeInterface $dateDeDebut): self
    {
        $this->dateDeDebut = $dateDeDebut;

        return $this;
    }

}
