<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use RonteLtd\CommonBundle\Entity\AbstractBaseEntity;
use RonteLtd\CommonBundle\Entity\CreatedAtTrait;
use RonteLtd\CommonBundle\Entity\UpdatedAtTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Class User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefaultRepository")
 */
class User extends AbstractBaseEntity implements UserInterface
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    const NAMESPACE = 'users';
    const LIMIT = 10;
    const CONFIRM_CODE_LIMIT_MINUTES = 3;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Groups({"default"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, unique=true)
     * @JMS\Groups({"default"})
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     * @JMS\Groups({"default"})
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=35, nullable=true)
     * @JMS\Groups({"default"})
     * @Assert\Regex(pattern= "/^\+?[\d]+$/")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="confirm_code", type="string", nullable=true)
     * @JMS\Groups({"default"})
     */
    private $confirmCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="confirm_code_created_at", type="datetime", nullable=true)
     * @JMS\Groups({"default"})
     */
    private $confirmCodeCreatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json_array")
     * @JMS\Groups({"default"})
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", nullable=true)
     * @JMS\Groups({"default"})
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", nullable=true)
     * @JMS\Groups({"default"})
     */
    private $lastName;

    /**
     * @var Locality
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Locality")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @JMS\Groups({"locality"})
     */
    private $locality;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CinemaManager", mappedBy="manager")
     * @JMS\Groups({"managers"})
     */
    private $cinemasManagers;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserOrder", mappedBy="user")
     * @JMS\Groups({"orders"})
     */
    private $orders;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmed", type="boolean")
     * @JMS\Groups({"default"})
     */
    private $confirmed;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     * @JMS\Groups({"default"})
     */
    private $enabled;

    /**
     * User constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->salt = md5(uniqid(null, true));
        $this->roles = ['ROLE_USER'];
        $this->cinemasManagers = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->confirmed = false;
        $this->enabled = false;

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
     * Get username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set phone
     *
     * @param string|null $phone
     *
     * @return User
     */
    public function setPhone(string $phone = null): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get confirm code
     *
     * @return string|null
     */
    public function getConfirmCode(): ?string
    {
        return $this->confirmCode;
    }

    /**
     * Set confirm code
     *
     * @param string|null $confirmCode
     *
     * @return User
     */
    public function setConfirmCode(string $confirmCode = null): self
    {
        $this->confirmCode = $confirmCode;

        return $this;
    }

    /**
     * Get confirm code created at
     *
     * @return \DateTime|null
     */
    public function getConfirmCodeCreatedAt(): ?\DateTime
    {
        return $this->confirmCodeCreatedAt;
    }

    /**
     * Set confirm code created at
     *
     * @param \DateTime|null $confirmCodeCreatedAt
     *
     * @return User
     */
    public function setConfirmCodeCreatedAt(\DateTime $confirmCodeCreatedAt = null)
    {
        $this->confirmCodeCreatedAt = $confirmCodeCreatedAt;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Add role
     *
     * @param string $role
     *
     * @return User
     */
    public function addRole(string $role): self
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * Remove role
     *
     * @param string $role
     *
     * @return User
     */
    public function removeRole(string $role): self
    {
        if (in_array($role, $this->roles)) {
            $key = array_search($role, $this->roles);
            unset($this->roles[$key]);
        }

        return $this;
    }

    /**
     * Get first name
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Set first name
     *
     * @param string|null $firstName
     *
     * @return User
     */
    public function setFirstName(string $firstName = null): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get last name
     *
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set last name
     *
     * @param string|null $lastName
     *
     * @return User
     */
    public function setLastName(string $lastName = null): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get locality
     *
     * @return Locality|null
     */
    public function getLocality(): ?Locality
    {
        return $this->locality;
    }

    /**
     * Set locality
     *
     * @param Locality|null $locality
     *
     * @return User
     */
    public function setLocality(Locality $locality = null): self
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get cinemas seats
     *
     * @return Collection
     */
    public function getCinemasManagers(): Collection
    {
        return $this->cinemasManagers;
    }

    /**
     * Add cinema manager
     *
     * @param CinemaManager $cinemaManager
     *
     * @return User
     */
    public function addCinemaManager(CinemaManager $cinemaManager): self
    {
        if (!$this->cinemasManagers->contains($cinemaManager)) {
            $this->cinemasManagers->add($cinemaManager);
        }

        return $this;
    }

    /**
     * Remove cinema manager
     *
     * @param CinemaManager $cinemaManager
     *
     * @return User
     */
    public function removeCinemaManager(CinemaManager $cinemaManager): self
    {
        if ($this->cinemasManagers->contains($cinemaManager)) {
            $this->cinemasManagers->removeElement($cinemaManager);
        }

        return $this;
    }

    /**
     * Get orders
     *
     * @return Collection
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * Add order
     *
     * @param UserOrder $order
     *
     * @return User
     */
    public function addOrder(UserOrder $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
        }

        return $this;
    }

    /**
     * Remove order
     *
     * @param UserOrder $order
     *
     * @return User
     */
    public function removeOrder(UserOrder $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
        }

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
     * @return User
     */
    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * Is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param bool $enabled
     *
     * @return User
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * {@inheritDoc}
     * @codeCoverageIgnore
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * {@inheritDoc}
     * @codeCoverageIgnore
     */
    public function eraseCredentials()
    {
    }
}