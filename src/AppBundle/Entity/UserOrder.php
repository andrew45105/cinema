<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RonteLtd\CommonBundle\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserOrder
 *
 * @ORM\Table(name="users_orders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefaultRepository")
 */
class UserOrder extends AbstractBaseEntity
{
    const STATUSES = [
        'STATUS_CONFIRMED',
        'STATUS_REJECTED',
    ];

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     * @Groups({"user"})
     */
    private $user;

    /**
     * @var Seance
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Seance")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Groups({"seance"})
     */
    private $seance;

    /**
     * @var CinemaSeat
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CinemaSeat")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Groups({"seat"})
     */
    private $cinemaSeat;

    /**
     * @var string
     *
     * @ORM\Column(name="spectator_type", type="string", length=64)
     * @Groups({"default"})
     * @Assert\NotBlank()
     */
    private $spectatorType;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=64)
     * @Groups({"default"})
     */
    private $status;

    /**
     * UserOrder constructor.
     *
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $this->status = static::STATUSES[0];

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
     * Set user
     *
     * @param User $user
     *
     * @return UserOrder
     */
    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Set seance
     *
     * @param Seance|null $seance
     *
     * @return UserOrder
     */
    public function setSeance(Seance $seance = null): self
    {
        $this->seance = $seance;

        return $this;
    }

    /**
     * Get seance
     *
     * @return Seance|null
     */
    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    /**
     * Set cinemaSeat
     *
     * @param CinemaSeat|null $cinemaSeat
     *
     * @return UserOrder
     */
    public function setCinemaSeat(CinemaSeat $cinemaSeat = null): self
    {
        $this->cinemaSeat = $cinemaSeat;

        return $this;
    }

    /**
     * Get cinemaSeat
     *
     * @return CinemaSeat|null
     */
    public function getCinemaSeat(): ?CinemaSeat
    {
        return $this->cinemaSeat;
    }

    /**
     * Set spectatorType
     *
     * @param string $spectatorType
     *
     * @return UserOrder
     */
    public function setSpectatorType(string $spectatorType): self
    {
        $this->spectatorType = $spectatorType;

        return $this;
    }

    /**
     * Get spectatorType
     *
     * @return string
     */
    public function getSpectatorType(): string
    {
        return $this->spectatorType;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return UserOrder
     */
    public function setStatus(string $status): self
    {
        if (in_array($status, static::STATUSES)) {
            $this->status = $status;
        }

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
