<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
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
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez donner un titre à l'article")
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="merci de rédiger le contenu de l'article")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $resaOpen = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inFront = false;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Keywords", inversedBy="articles")
     */
    private $keywords;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Theme", inversedBy="articles")
     */
    private $themes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="articles")
     */
    private $reservations;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $showDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favArticles")
     */
    private $favUsers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="author")
     * @ORM\JoinColumn(nullable=false)
     */
    private $authorOf;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $placesLeft = 100;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->keywords = new ArrayCollection();
        $this->themes = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->favUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getResaOpen(): ?bool
    {
        return $this->resaOpen;
    }

    public function setResaOpen(bool $resaOpen): self
    {
        $this->resaOpen = $resaOpen;

        return $this;
    }

    public function getInFront(): ?bool
    {
        return $this->inFront;
    }

    public function setInFront(bool $inFront): self
    {
        $this->inFront = $inFront;

        return $this;
    }

    /**
     * @return Collection|Keywords[]
     */
    public function getKeywords(): Collection
    {
        return $this->keywords;
    }

    public function addKeyword(Keywords $keyword): self
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords[] = $keyword;
        }

        return $this;
    }

    public function removeKeyword(Keywords $keyword): self
    {
        if ($this->keywords->contains($keyword)) {
            $this->keywords->removeElement($keyword);
        }

        return $this;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->themes->contains($theme)) {
            $this->themes->removeElement($theme);
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setArticles($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getArticles() === $this) {
                $reservation->setArticles(null);
            }
        }

        return $this;
    }

    public function getShowDate(): ?\DateTimeInterface
    {
        return $this->showDate;
    }

    public function setShowDate(?\DateTimeInterface $showDate): self
    {
        $this->showDate = $showDate;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFavUsers(): Collection
    {
        return $this->favUsers;
    }

    public function addFavUser(User $favUser): self
    {
        if (!$this->favUsers->contains($favUser)) {
            $this->favUsers[] = $favUser;
            $favUser->addFavArticle($this);
        }

        return $this;
    }

    public function removeFavUser(User $favUser): self
    {
        if ($this->favUsers->contains($favUser)) {
            $this->favUsers->removeElement($favUser);
            $favUser->removeFavArticle($this);
        }

        return $this;
    }

    public function getAuthorOf(): ?User
    {
        return $this->authorOf;
    }

    public function setAuthorOf(?User $authorOf): self
    {
        $this->authorOf = $authorOf;

        return $this;
    }

    public function getPlacesLeft(): ?int
    {
        return $this->placesLeft;
    }

    public function setPlacesLeft(?int $placesLeft): self
    {
        $this->placesLeft = $placesLeft;

        return $this;
    }
}
