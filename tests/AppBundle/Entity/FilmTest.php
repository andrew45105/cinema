<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Film;
use AppBundle\Entity\Genre;
use Doctrine\Common\Collections\Collection;
use Tests\BaseTestCase;

/**
 * Class FilmTest
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class FilmTest extends BaseTestCase
{
    /**
     * @var Film
     */
    private $film;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->film = new Film();
    }

    /**
     * Tests construct
     */
    public function testConstruct()
    {
        self::assertInstanceOf(Film::class, new Film());
    }

    /**
     * Tests get id
     *
     * @covers \AppBundle\Entity\Film::getId()
     */
    public function testGetId()
    {
        $this->setValueToProperty($this->film, 'id', 1);

        $id = $this->film->getId();
        self::assertInternalType('int', $id);
        self::assertEquals(1, $id);
    }

    /**
     * Tests set and get type
     *
     * @covers \AppBundle\Entity\Film::setType()
     * @covers \AppBundle\Entity\Film::getType()
     */
    public function testSetGetType()
    {
        $type = Film::TYPES[1];
        self::assertInstanceOf(Film::class, $this->film->setType($type));
        self::assertEquals($this->film->getType(), Film::TYPES[1]);

        $type = 'some type';
        self::assertInstanceOf(Film::class, $this->film->setType($type));
        self::assertEquals($this->film->getType(), Film::TYPES[3]);
    }

    /**
     * Tests add genre and get genres
     *
     * @covers \AppBundle\Entity\Film::addGenre()
     * @covers \AppBundle\Entity\Film::getGenres()
     *
     * @return Film
     */
    public function testAddGetGenres()
    {
        $genre = new Genre(['slug' => 'action']);
        self::assertInstanceOf(Film::class, $this->film->addGenre($genre));

        $genres = $this->film->getGenres();
        self::assertInstanceOf(Collection::class, $genres);
        self::assertCount(1, $genres);
        self::assertInstanceOf(Genre::class, $genres->first());
        self::assertEquals($genre->getSlug(), $genres->first()->getSlug());

        return $genre;
    }

    /**
     * Tests remove genre and get genres
     *
     * @param Genre $genre
     *
     * @covers \AppBundle\Entity\Film::removeGenre()
     * @covers \AppBundle\Entity\Film::getGenres()
     * @depends testAddGetGenres
     */
    public function testRemoveGetGenres(Genre $genre)
    {
        self::assertInstanceOf(Film::class, $this->film->removeGenre($genre));

        $genres = $this->film->getGenres();
        self::assertInstanceOf(Collection::class, $genres);
        self::assertCount(0, $genres);
    }

    /**
     * Tests set and get title
     *
     * @covers \AppBundle\Entity\Film::setTitle()
     * @covers \AppBundle\Entity\Film::getTitle()
     */
    public function testSetGetTitle()
    {
        $title = 'some title';
        self::assertInstanceOf(Film::class, $this->film->setTitle($title));
        self::assertEquals($this->film->getTitle(), $title);
    }

    /**
     * Tests set and get description
     *
     * @covers \AppBundle\Entity\Film::setDescription()
     * @covers \AppBundle\Entity\Film::getDescription()
     */
    public function testSetGetDescription()
    {
        $description = 'some description';
        self::assertInstanceOf(Film::class, $this->film->setDescription($description));
        self::assertEquals($this->film->getDescription(), $description);
    }

    /**
     * Tests set and get duration
     *
     * @covers \AppBundle\Entity\Film::setDuration()
     * @covers \AppBundle\Entity\Film::getDuration()
     */
    public function testSetGetDuration()
    {
        $duration = 112;
        self::assertInstanceOf(Film::class, $this->film->setDuration($duration));
        self::assertEquals($this->film->getDuration(), $duration);
    }

    /**
     * Tests set and get min age
     *
     * @covers \AppBundle\Entity\Film::setMinAge()
     * @covers \AppBundle\Entity\Film::getMinAge()
     */
    public function testSetGetMinAge()
    {
        $minAge = 16;
        self::assertInstanceOf(Film::class, $this->film->setMinAge($minAge));
        self::assertEquals($this->film->getMinAge(), $minAge);
    }

    /**
     * Tests set and get year of make
     *
     * @covers \AppBundle\Entity\Film::setYearOfMake()
     * @covers \AppBundle\Entity\Film::getYearOfMake()
     */
    public function testSetGetYearOfMake()
    {
        $yearOfMake = 2015;
        self::assertInstanceOf(Film::class, $this->film->setYearOfMake($yearOfMake));
        self::assertEquals($this->film->getYearOfMake(), $yearOfMake);
    }
    
    /**
     * Tests set and get links
     *
     * @covers \AppBundle\Entity\Film::setLinks()
     * @covers \AppBundle\Entity\Film::getLinks()
     */
    public function testSetGetLinks()
    {
        $links = [
            'site' => 'http://site.com',
        ];
        self::assertInstanceOf(Film::class, $this->film->setLinks($links));
        self::assertEquals($this->film->getLinks(), $links);
    }
}