<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPlaceChild;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer le nombre d'adultes inscrits")
     */
    private $nbPlaceAdult;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="reservations")
     * @Assert\NotBlank(message="Veuillez indiquer pour quel évènement vous réservez")
     */
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accepted = false;

    public function __construct()
    {
        $this -> createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbPlaceChild(): ?int
    {
        return $this->nbPlaceChild;
    }

    public function setNbPlaceChild(?int $nbPlaceChild): self
    {
        $this->nbPlaceChild = $nbPlaceChild;

        return $this;
    }

    public function getNbPlaceAdult(): ?int
    {
        return $this->nbPlaceAdult;
    }

    public function setNbPlaceAdult(int $nbPlaceAdult): self
    {
        $this->nbPlaceAdult = $nbPlaceAdult;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getArticles(): ?Article
    {
        return $this->articles;
    }

    public function setArticles(?Article $articles): self
    {
        $this->articles = $articles;

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

    public function getAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }
}
