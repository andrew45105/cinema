<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Seance;
use AppBundle\Entity\SeancePrice;
use Tests\BaseTestCase;

/**
 * Class SeancePriceTest
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class SeancePriceTest extends BaseTestCase
{
    /**
     * @var SeancePrice
     */
    private $seancePrice;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->seancePrice = new SeancePrice();
    }

    /**
     * Tests construct
     */
    public function testConstruct()
    {
        self::assertInstanceOf(SeancePrice::class, new SeancePrice());
    }

    /**
     * Tests set and get seance
     *
     * @covers \AppBundle\Entity\SeancePrice::setSeance()
     * @covers \AppBundle\Entity\SeancePrice::getSeance()
     */
    public function testSetGetSeance()
    {
        $dateTime = new \DateTime();
        $newSeance = new Seance([
            'showingAt' => $dateTime,
        ]);
        self::assertInstanceOf(SeancePrice::class, $this->seancePrice->setSeance($newSeance));

        $seance = $this->seancePrice->getSeance();
        self::assertInstanceOf(Seance::class, $seance);
        self::assertEquals(
            $newSeance->getShowingAt()->getTimestamp(),
            $seance->getShowingAt()->getTimestamp()
        );
    }

    /**
     * Tests set and get spectator type
     *
     * @covers \AppBundle\Entity\SeancePrice::setSpectatorType()
     * @covers \AppBundle\Entity\SeancePrice::getSpectatorType()
     */
    public function testSetGetSpectatorType()
    {
        self::assertEquals($this->seancePrice->getSpectatorType(), 'default');

        $spectatorType = 'some type';
        self::assertInstanceOf(SeancePrice::class, $this->seancePrice->setSpectatorType($spectatorType));
        self::assertEquals($this->seancePrice->getSpectatorType(), $spectatorType);
    }

    /**
     * Tests set and get price
     *
     * @covers \AppBundle\Entity\SeancePrice::setPrice()
     * @covers \AppBundle\Entity\SeancePrice::getPrice()
     */
    public function testSetGetPrice()
    {
        $price = 240;
        self::assertInstanceOf(SeancePrice::class, $this->seancePrice->setPrice($price));
        self::assertEquals($this->seancePrice->getPrice(), $price);
    }
}