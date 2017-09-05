<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use RonteLtd\CommonBundle\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cinema
 *
 * @ORM\Table(name="cinemas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefaultRepository")
 */
class Cinema extends AbstractBaseEntity
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"default"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var Locality
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Locality")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     * @Groups({"locality"})
     */
    private $locality;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CinemaSeat", mappedBy="cinema")
     * @Groups({"seats"})
     */
    private $cinemasSeats;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     * @Groups({"default"})
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @var array
     *
     * @ORM\Column(name="contacts", type="json_array", nullable=true)
     * @Groups({"default"})
     */
    private $contacts;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmed", type="boolean")
     * @Groups({"default"})
     */
    private $confirmed;

    /**
     * Cinema constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->cinemasSeats = new ArrayCollection();
        $this->confirmed = false;

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
     * Set name
     *
     * @param string $name
     *
     * @return Cinema
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set locality
     *
     * @param Locality $locality
     *
     * @return Cinema
     */
    public function setLocality(Locality $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return Locality
     */
    public function getLocality(): Locality
    {
        return $this->locality;
    }

    /**
     * Get cinemas seats
     *
     * @return Collection
     */
    public function getCinemasSeats(): Collection
    {
        return $this->cinemasSeats;
    }

    /**
     * Add cinema seat
     *
     * @param CinemaSeat $cinemaSeat
     *
     * @return Cinema
     */
    public function addCinemaSeat(CinemaSeat $cinemaSeat): self
    {
        if (!$this->cinemasSeats->contains($cinemaSeat)) {
            $this->cinemasSeats->add($cinemaSeat);
            $cinemaSeat->setCinema($this);
        }

        return $this;
    }

    /**
     * Remove cinema seat
     *
     * @param CinemaSeat $cinemaSeat
     *
     * @return Cinema
     */
    public function removeCinemaSeat(CinemaSeat $cinemaSeat): self
    {
        if ($this->cinemasSeats->contains($cinemaSeat)) {
            $this->cinemasSeats->removeElement($cinemaSeat);
        }

        return $this;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Cinema
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Get contacts
     *
     * @return array|null
     */
    public function getContacts(): ?array
    {
        return $this->contacts;
    }

    /**
     * Set contacts
     *
     * @param array|null $contacts
     *
     * @return Cinema
     */
    public function setContacts(array $contacts = null): self
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * Is confirmed
     *
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    /**
     * Set confirmed
     *
     * @param bool $confirmed
     *
     * @return Cinema
     */
    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }
}

