<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Cinema;
use AppBundle\Entity\Film;
use AppBundle\Entity\Seance;
use AppBundle\Entity\SeancePrice;
use Doctrine\Common\Collections\Collection;
use Tests\BaseTestCase;

/**
 * Class SeanceTest
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class SeanceTest extends BaseTestCase
{
    /**
     * @var Seance
     */
    private $seance;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->seance = new Seance();
    }

    /**
     * Tests construct
     */
    public function testConstruct()
    {
        self::assertInstanceOf(Seance::class, new Seance());
    }

    /**
     * Tests get id
     *
     * @covers \AppBundle\Entity\Seance::getId()
     */
    public function testGetId()
    {
        $this->setValueToProperty($this->seance, 'id', 1);

        $id = $this->seance->getId();
        self::assertInternalType('int', $id);
        self::assertEquals(1, $id);
    }

    /**
     * Tests set and get cinema
     *
     * @covers \AppBundle\Entity\Seance::setCinema()
     * @covers \AppBundle\Entity\Seance::getCinema()
     */
    public function testSetGetCinema()
    {
        $newCinema = new Cinema([
            'name' => 'some name',
        ]);
        self::assertInstanceOf(Seance::class, $this->seance->setCinema($newCinema));

        $cinema = $this->seance->getCinema();
        self::assertInstanceOf(Cinema::class, $cinema);
        self::assertEquals($newCinema->getName(), $cinema->getName());
    }

    /**
     * Tests set and get film
     *
     * @covers \AppBundle\Entity\Seance::setFilm()
     * @covers \AppBundle\Entity\Seance::getFilm()
     */
    public function testSetGetFilm()
    {
        $newFilm = new Film([
            'title' => 'some title',
        ]);
        self::assertInstanceOf(Seance::class, $this->seance->setFilm($newFilm));

        $film = $this->seance->getFilm();
        self::assertInstanceOf(Film::class, $film);
        self::assertEquals($newFilm->getTitle(), $film->getTitle());
    }

    /**
     * Tests set and get showing at
     *
     * @covers \AppBundle\Entity\Seance::setShowingAt()
     * @covers \AppBundle\Entity\Seance::getShowingAt()
     */
    public function testSetGetShowingAt()
    {
        $newShowingAt = new \DateTime();
        self::assertInstanceOf(Seance::class, $this->seance->setShowingAt($newShowingAt));

        $showingAt = $this->seance->getShowingAt();
        self::assertInstanceOf(\DateTime::class, $showingAt);
        self::assertEquals($newShowingAt->getTimestamp(), $showingAt->getTimestamp());
    }

    /**
     * Tests add seance price and get seances prices
     *
     * @covers \AppBundle\Entity\Seance::addSeancePrice()
     * @covers \AppBundle\Entity\Seance::getSeancesPrices()
     *
     * @return SeancePrice
     */
    public function testAddGetSeancesPrices()
    {
        $seancePrice = new SeancePrice(['price' => 100]);
        self::assertInstanceOf(Seance::class, $this->seance->addSeancePrice($seancePrice));

        $seancesPrices = $this->seance->getSeancesPrices();
        self::assertInstanceOf(Collection::class, $seancesPrices);
        self::assertCount(1, $seancesPrices);
        self::assertInstanceOf(SeancePrice::class, $seancesPrices->first());
        self::assertEquals($seancePrice->getPrice(), $seancesPrices->first()->getPrice());

        return $seancePrice;
    }

    /**
     * Tests remove seance price and get seances prices
     *
     * @param SeancePrice $seancePrice
     *
     * @covers \AppBundle\Entity\Seance::removeSeancePrice()
     * @covers \AppBundle\Entity\Seance::getSeancesPrices()
     * @depends testAddGetSeancesPrices
     */
    public function testRemoveGetSeancesPrices(SeancePrice $seancePrice)
    {
        self::assertInstanceOf(Seance::class, $this->seance->removeSeancePrice($seancePrice));

        $seancesPrices = $this->seance->getSeancesPrices();
        self::assertInstanceOf(Collection::class, $seancesPrices);
        self::assertCount(0, $seancesPrices);
    }
}