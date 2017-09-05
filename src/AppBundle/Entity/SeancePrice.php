<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RonteLtd\CommonBundle\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SeancePrice
 *
 * @ORM\Table(name="seances_prices")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefaultRepository")
 */
class SeancePrice extends AbstractBaseEntity
{
    /**
     * @var Seance
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Seance")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     * @Groups({"seance"})
     */
    private $seance;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="spectator_type", type="string", length=64)
     * @Groups({"default"})
     */
    private $spectatorType;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     * @Groups({"default"})
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * SeancePrice constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->spectatorType = 'default';

        parent::__construct($data);
    }

    /**
     * Set seance
     *
     * @param Seance $seance
     *
     * @return SeancePrice
     */
    public function setSeance(Seance $seance): self
    {
        $this->seance = $seance;

        return $this;
    }

    /**
     * Get seance
     *
     * @return Seance
     */
    public function getSeance(): Seance
    {
        return $this->seance;
    }

    /**
     * Set spectator type
     *
     * @param string $spectatorType
     *
     * @return SeancePrice
     */
    public function setSpectatorType(string $spectatorType): self
    {
        $this->spectatorType = $spectatorType;

        return $this;
    }

    /**
     * Get spectator type
     *
     * @return string
     */
    public function getSpectatorType(): string
    {
        return $this->spectatorType;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return SeancePrice
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }
}

