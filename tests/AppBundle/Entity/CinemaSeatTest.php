<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Cinema;
use AppBundle\Entity\CinemaSeat;
use Tests\BaseTestCase;

/**
 * Class CinemaSeatTest
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class CinemaSeatTest extends BaseTestCase
{
    /**
     * @var CinemaSeat
     */
    private $cinemaSeat;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->cinemaSeat = new CinemaSeat();
    }

    /**
     * Tests construct
     */
    public function testConstruct()
    {
        self::assertInstanceOf(CinemaSeat::class, new CinemaSeat());
    }

    /**
     * Tests get id
     *
     * @covers \AppBundle\Entity\CinemaSeat::getId()
     */
    public function testGetId()
    {
        $this->setValueToProperty($this->cinemaSeat, 'id', 1);

        $id = $this->cinemaSeat->getId();
        self::assertInternalType('int', $id);
        self::assertEquals(1, $id);
    }

    /**
     * Tests set and get cinema
     *
     * @covers \AppBundle\Entity\CinemaSeat::setCinema()
     * @covers \AppBundle\Entity\CinemaSeat::getCinema()
     */
    public function testSetGetCinema()
    {
        $newCinema = new Cinema([
            'name' => 'Some Cinema',
        ]);
        self::assertInstanceOf(CinemaSeat::class, $this->cinemaSeat->setCinema($newCinema));

        $cinema = $this->cinemaSeat->getCinema();
        self::assertInstanceOf(Cinema::class, $cinema);
        self::assertEquals($newCinema->getName(), $cinema->getName());
    }

    /**
     * Tests set and get seat number
     *
     * @covers \AppBundle\Entity\CinemaSeat::setSeatNumber()
     * @covers \AppBundle\Entity\CinemaSeat::getSeatNumber()
     */
    public function testSetGetSeatNumber()
    {
        $seatNumber = 'A12';
        self::assertInstanceOf(CinemaSeat::class, $this->cinemaSeat->setSeatNumber($seatNumber));
        self::assertEquals($this->cinemaSeat->getSeatNumber(), $seatNumber);
    }
}