<?php

namespace App\Entity;

use App\Repository\EscapeGameRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity("nom")
 * @ORM\Entity(repositoryClass=EscapeGameRepository::class)
 */
class EscapeGame
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jeux;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $dureeEnMinute;

    /**
     * @ORM\Column(type="string", length=999999999999)
     *   @Assert\Image(
     *     mimeTypes={"image/jpeg", "image/png", "image/gif"},
     *     mimeTypesMessage = "Please upload a valid Image",
     *     maxSize="9024k"
     * )
     * 
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partie", mappedBy="escapeGame")
     */
    private $partie;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getJeux(): ?string
    {
        return $this->jeux;
    }

    public function setJeux(string $jeux): self
    {
        $this->jeux = $jeux;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
    public function getDureeEnMinute(): ?int
    {
        return $this->dureeEnMinute;
    }

    public function setDureeEnMinute(int $dureeEnMinute): self
    {
        $this->dureeEnMinute = $dureeEnMinute;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

}
