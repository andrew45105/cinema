<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RonteLtd\CommonBundle\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * CinemaManager
 *
 * @ORM\Table(name="cinemas_managers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefaultRepository")
 */
class CinemaManager extends AbstractBaseEntity
{
    /**
     * @var Cinema
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cinema")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     * @Groups({"cinema"})
     */
    private $cinema;

    /**
     * @var User
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     * @Groups({"manager"})
     */
    private $manager;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmed", type="boolean")
     * @Groups({"default"})
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
     * @return Cinema
     */
    public function getCinema(): Cinema
    {
        return $this->cinema;
    }

    /**
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
     * @return User
     */
    public function getManager(): User
    {
        return $this->manager;
    }

    /**
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
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    /**
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