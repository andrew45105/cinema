<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RonteLtd\CommonBundle\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CinemaSeat
 *
 * @ORM\Table(
 *      name="cinemas_seats",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="seat_idx", columns={"cinema_id", "seat_number"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefaultRepository")
 */
class CinemaSeat extends AbstractBaseEntity
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
     * @ORM\JoinColumn(onDelete="cascade")
     * @Groups({"cinema"})
     */
    private $cinema;

    /**
     * @var string
     *
     * @ORM\Column(name="seat_number", type="string", length=32)
     * @Groups({"default"})
     * @Assert\NotBlank()
     */
    private $seatNumber;

    /**
     * CinemaSeat constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
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
     * @return CinemaSeat
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
     * Set seatNumber
     *
     * @param string $seatNumber
     *
     * @return CinemaSeat
     */
    public function setSeatNumber(string $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    /**
     * Get seatNumber
     *
     * @return string
     */
    public function getSeatNumber(): string
    {
        return $this->seatNumber;
    }
}
