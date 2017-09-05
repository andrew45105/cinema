<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use RonteLtd\CommonBundle\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Seance
 *
 * @ORM\Table(name="seances")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefaultRepository")
 */
class Seance extends AbstractBaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"default"})
     */
    private $id;

    /**
     * @var Cinema
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cinema")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     * @Groups({"cinema"})
     */
    private $cinema;

    /**
     * @var Film
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Film")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     * @Groups({"film"})
     */
    private $film;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="showing_at", type="datetime")
     * @Groups({"default"})
     * @Assert\NotBlank()
     */
    private $showingAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SeancePrice", mappedBy="seance")
     * @Groups({"prices"})
     */
    private $seancesPrices;

    /**
     * Seance constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->seancesPrices = new ArrayCollection();

        parent::__construct($data);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set cinema
     *
     * @param Cinema $cinema
     *
     * @return Seance
     */
    public function setCinema(Cinema $cinema): self
    {
        $this->cinema = $cinema;

        return $this;
    }

    /**
     * Get cinema
     *
     * @return Cinema
     */
    public function getCinema(): Cinema
    {
        return $this->cinema;
    }

    /**
     * Set film
     *
     * @param Film $film
     *
     * @return Seance
     */
    public function setFilm(Film $film): self
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return Film
     */
    public function getFilm(): Film
    {
        return $this->film;
    }

    /**
     * Set showing at
     *
     * @param \DateTime $showingAt
     *
     * @return Seance
     */
    public function setShowingAt(\DateTime $showingAt): self
    {
        $this->showingAt = $showingAt;

        return $this;
    }

    /**
     * Get showing at
     *
     * @return \DateTime
     */
    public function getShowingAt(): \DateTime
    {
        return $this->showingAt;
    }

    /**
     * Get seances prices
     *
     * @return Collection
     */
    public function getSeancesPrices(): Collection
    {
        return $this->seancesPrices;
    }

    /**
     * Add seance price
     *
     * @param SeancePrice $seancePrice
     *
     * @return Seance
     */
    public function addSeancePrice(SeancePrice $seancePrice): self
    {
        if (!$this->seancesPrices->contains($seancePrice)) {
            $this->seancesPrices->add($seancePrice);
            $seancePrice->setSeance($this);
        }

        return $this;
    }

    /**
     * Remove seance price
     *
     * @param SeancePrice $seancePrice
     *
     * @return Seance
     */
    public function removeSeancePrice(SeancePrice $seancePrice): self
    {
        if ($this->seancesPrices->contains($seancePrice)) {
            $this->seancesPrices->removeElement($seancePrice);
        }

        return $this;
    }
}

