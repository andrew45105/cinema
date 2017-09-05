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
use Symfony\Component\Serializer\Annotation\Groups;

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
    const CODE_UPDATED_LIMIT_HOURS = 24;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"default"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=35, unique=true)
     * @Groups({"default"})
     * @Assert\NotBlank()
     * @Assert\Regex(pattern= "/^\+?[\d]+$/")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="auth_code", type="string")
     * @Assert\NotBlank()
     */
    private $authCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="auth_code_updated_at", type="datetime")
     * @Assert\NotBlank()
     */
    private $authCodeUpdatedAt;

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
     * @Groups({"Default"})
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", nullable=true)
     * @Groups({"default"})
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", nullable=true)
     * @Groups({"default"})
     */
    private $lastName;

    /**
     * @var Locality
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Locality")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Groups({"locality"})
     */
    private $locality;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CinemaManager", mappedBy="manager")
     * @Groups({"managers"})
     */
    private $cinemasManagers;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserOrder", mappedBy="user")
     * @Groups({"orders"})
     */
    private $orders;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     * @Groups({"default"})
     */
    private $enabled;

    /**
     * User constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->authCodeUpdatedAt = new \DateTime();
        $this->salt = md5(uniqid(null, true));
        $this->roles = ['ROLE_USER'];
        $this->cinemasManagers = new ArrayCollection();
        $this->orders = new ArrayCollection();
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
     * Get phone
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get auth code
     *
     * @return string
     */
    public function getAuthCode(): string
    {
        return $this->authCode;
    }

    /**
     * Set auth code
     *
     * @param string $authCode
     *
     * @return User
     */
    public function setAuthCode(string $authCode): self
    {
        $this->authCode = $authCode;

        return $this;
    }

    /**
     * Get auth code updated at
     *
     * @return \DateTime
     */
    public function getAuthCodeUpdatedAt(): \DateTime
    {
        return $this->authCodeUpdatedAt;
    }

    /**
     * Set auth code updated at
     *
     * @param \DateTime $authCodeUpdatedAt
     *
     * @return User
     */
    public function setAuthCodeUpdatedAt(\DateTime $authCodeUpdatedAt)
    {
        $this->authCodeUpdatedAt = $authCodeUpdatedAt;

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
    public function getPassword()
    {
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
    public function getUsername()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     * @codeCoverageIgnore
     */
    public function eraseCredentials()
    {
    }
}