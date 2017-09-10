<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RonteLtd\CommonBundle\Entity\AbstractBaseEntity;
use JMS\Serializer\Annotation as JMS;

/**
 * CinemaManager
 *
 * @ORM\Table(
 *     name="cinemas_managers",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="manager_idx", columns={"cinema_id", "manager_id"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefaultRepository")
 */
class CinemaManager extends AbstractBaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Groups({"default"})
     */
    private $id;

    /**
     * @var Cinema
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cinema")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     * @JMS\Groups({"cinema"})
     */
    private $cinema;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     * @JMS\Groups({"manager"})
     */
    private $manager;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmed", type="boolean")
     * @JMS\Groups({"default"})
     */
    private $confirmed;

    /**
     * CinemaManager constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
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
     * Get cinema
     *
     * @return Cinema
     */
    public function getCinema(): Cinema
    {
        return $this->cinema;
    }

    /**
     * Set cinema
     *
     * @param Cinema $cinema
     *
     * @return CinemaManager
     */
    public function setCinema(Cinema $cinema): self
    {
        $this->cinema = $cinema;

        return $this;
    }

    /**
     * Get manager
     *
     * @return User
     */
    public function getManager(): User
    {
        return $this->manager;
    }

    /**
     * Set manager
     *
     * @param User $manager
     *
     * @return CinemaManager
     */
    public function setManager(User $manager): self
    {
        $this->manager = $manager;

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
     * @return CinemaManager
     */
    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }
}