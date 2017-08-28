<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Genre;
use Tests\BaseTestCase;

/**
 * Class GenreTest
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class GenreTest extends BaseTestCase
{
    /**
     * @var Genre
     */
    private $genre;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->genre = new Genre();
    }

    /**
     * Tests construct
     */
    public function testConstruct()
    {
        self::assertInstanceOf(Genre::class, new Genre());
    }

    /**
     * Tests get id
     *
     * @covers \AppBundle\Entity\Genre::getId()
     */
    public function testGetId()
    {
        $this->setValueToProperty($this->genre, 'id', 1);

        $id = $this->genre->getId();
        self::assertInternalType('int', $id);
        self::assertEquals(1, $id);
    }

    /**
     * Tests set and get title
     *
     * @covers \AppBundle\Entity\Genre::setTitle()
     * @covers \AppBundle\Entity\Genre::getTitle()
     */
    public function testSetGetTitle()
    {
        $title = 'some title';
        self::assertInstanceOf(Genre::class, $this->genre->setTitle($title));
        self::assertEquals($this->genre->getTitle(), $title);
    }

    /**
     * Tests set and get slug
     *
     * @covers \AppBundle\Entity\Genre::setSlug()
     * @covers \AppBundle\Entity\Genre::getSlug()
     */
    public function testSetGetSlug()
    {
        $slug = 'some_slug';
        self::assertInstanceOf(Genre::class, $this->genre->setSlug($slug));
        self::assertEquals($this->genre->getSlug(), $slug);
    }
}