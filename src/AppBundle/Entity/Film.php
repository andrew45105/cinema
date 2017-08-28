<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use RonteLtd\CommonBundle\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Film
 *
 * @ORM\Table(
 *      name="films",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="film_idx", columns={"title", "year_of_make"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefaultRepository")
 */
class Film extends AbstractBaseEntity
{
    const TYPES = [
        'TYPE_FILM',
        'TYPE_CARTOON',
        'TYPE_DOCUMENTARY',
        'TYPE_OTHER',
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=64, nullable=true)
     * @Groups({"default"})
     */
    private $type;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Genre")
     * @ORM\JoinTable(name="films_genres")
     * @Groups({"genres"})
     */
    private $genres;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Groups({"default"})
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Groups({"default"})
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     * @Groups({"default"})
     * @Assert\NotBlank()
     */
    private $duration;

    /**
     * @var int
     *
     * @ORM\Column(name="min_age", type="integer")
     * @Groups({"default"})
     */
    private $minAge;

    /**
     * @var int
     *
     * @ORM\Column(name="year_of_make", type="integer")
     * @Groups({"default"})
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[\d]{4}$/")
     */
    private $yearOfMake;

    /**
     * @var array
     *
     * @ORM\Column(name="links", type="json_array", nullable=true)
     * @Groups({"default"})
     */
    private $links;

    /**
     * Film constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->genres = new ArrayCollection();
        $this->minAge = 0;

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
     * Set type
     *
     * @param string|null $type
     *
     * @return Film
     */
    public function setType(string $type = null): self
    {
        if (!in_array($type, static::TYPES)) {
            $type = static::TYPES[3];
        }
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return Collection
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    /**
     * @param Genre $genre
     *
     * @return Film
     */
    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    /**
     * @param Genre $genre
     *
     * @return Film
     */
    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
        }

        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Film
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Film
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Film
     */
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * Set minAge
     *
     * @param integer $minAge
     *
     * @return Film
     */
    public function setMinAge(int $minAge): self
    {
        $this->minAge = $minAge;

        return $this;
    }

    /**
     * Get minAge
     *
     * @return int
     */
    public function getMinAge(): int
    {
        return $this->minAge;
    }

    /**
     * Set yearOfMake
     *
     * @param integer $yearOfMake
     *
     * @return Film
     */
    public function setYearOfMake(int $yearOfMake): self
    {
        $this->yearOfMake = $yearOfMake;

        return $this;
    }

    /**
     * Get yearOfMake
     *
     * @return int
     */
    public function getYearOfMake(): int
    {
        return $this->yearOfMake;
    }

    /**
     * Set links
     *
     * @param array|null $links
     *
     * @return Film
     */
    public function setLinks(array $links = null): self
    {
        $this->links = $links;

        return $this;
    }

    /**
     * Get links
     *
     * @return array|null
     */
    public function getLinks(): ?array
    {
        return $this->links;
    }
}