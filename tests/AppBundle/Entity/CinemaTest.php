<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Cinema;
use AppBundle\Entity\CinemaSeat;
use AppBundle\Entity\Locality;
use Doctrine\Common\Collections\Collection;
use Tests\BaseTestCase;

/**
 * Class CinemaTest
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class CinemaTest extends BaseTestCase
{
    /**
     * @var Cinema
     */
    private $cinema;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->cinema = new Cinema();
    }

    /**
     * Tests construct
     */
    public function testConstruct()
    {
        self::assertInstanceOf(Cinema::class, new Cinema());
    }

    /**
     * Tests get id
     *
     * @covers \AppBundle\Entity\Cinema::getId()
     */
    public function testGetId()
    {
        $this->setValueToProperty($this->cinema, 'id', 1);

        $id = $this->cinema->getId();
        self::assertInternalType('int', $id);
        self::assertEquals(1, $id);
    }

    /**
     * Tests set and get name
     *
     * @covers \AppBundle\Entity\Cinema::setName()
     * @covers \AppBundle\Entity\Cinema::getName()
     */
    public function testSetGetName()
    {
        $name = 'some name';
        self::assertInstanceOf(Cinema::class, $this->cinema->setName($name));
        self::assertEquals($this->cinema->getName(), $name);
    }

    /**
     * Tests set and get locality
     *
     * @covers \AppBundle\Entity\Cinema::setLocality()
     * @covers \AppBundle\Entity\Cinema::getLocality()
     */
    public function testSetGetLocality()
    {
        $newLocality = new Locality([
            'name' => 'some locality',
        ]);
        self::assertInstanceOf(Cinema::class, $this->cinema->setLocality($newLocality));

        $locality = $this->cinema->getLocality();
        self::assertInstanceOf(Locality::class, $locality);
        self::assertEquals($newLocality->getName(), $locality->getName());
    }

    /**
     * Tests add cinema seat and get cinemas seats
     *
     * @covers \AppBundle\Entity\Cinema::addCinemaSeat()
     * @covers \AppBundle\Entity\Cinema::getCinemasSeats()
     *
     * @return CinemaSeat
     */
    public function testAddGetCinemasSeats()
    {
        $seat = new CinemaSeat(['seatNumber' => 'A1']);
        self::assertInstanceOf(Cinema::class, $this->cinema->addCinemaSeat($seat));

        $seats = $this->cinema->getCinemasSeats();
        self::assertInstanceOf(Collection::class, $seats);
        self::assertCount(1, $seats);
        self::assertInstanceOf(CinemaSeat::class, $seats->first());
        self::assertEquals($seat->getSeatNumber(), $seats->first()->getSeatNumber());

        return $seat;
    }

    /**
     * Tests remove cinema seat and get cinemas seats
     *
     * @param CinemaSeat $seat
     *
     * @covers \AppBundle\Entity\Cinema::removeCinemaSeat()
     * @covers \AppBundle\Entity\Cinema::getCinemasSeats()
     * @depends testAddGetCinemasSeats
     */
    public function testRemoveGetCinemasSeats(CinemaSeat $seat)
    {
        self::assertInstanceOf(Cinema::class, $this->cinema->removeCinemaSeat($seat));

        $seats = $this->cinema->getCinemasSeats();
        self::assertInstanceOf(Collection::class, $seats);
        self::assertCount(0, $seats);
    }

    /**
     * Tests set and get address
     *
     * @covers \AppBundle\Entity\Cinema::setAddress()
     * @covers \AppBundle\Entity\Cinema::getAddress()
     */
    public function testSetGetAddress()
    {
        $address = 'some address';
        self::assertInstanceOf(Cinema::class, $this->cinema->setAddress($address));
        self::assertEquals($this->cinema->getAddress(), $address);
    }

    /**
     * Tests set and get contacts
     *
     * @covers \AppBundle\Entity\Cinema::setContacts()
     * @covers \AppBundle\Entity\Cinema::getContacts()
     */
    public function testSetGetContacts()
    {
        $contacts = [
            'some key' => 'some value',
        ];
        self::assertInstanceOf(Cinema::class, $this->cinema->setContacts($contacts));
        self::assertEquals($this->cinema->getContacts(), $contacts);
    }

    /**
     * Tests set and is confirmed
     *
     * @covers \AppBundle\Entity\Cinema::setConfirmed()
     * @covers \AppBundle\Entity\Cinema::isConfirmed()
     */
    public function testSetIsConfirmed()
    {
        self::assertFalse($this->cinema->isConfirmed());
        self::assertInstanceOf(Cinema::class, $this->cinema->setConfirmed(true));
        self::assertTrue($this->cinema->isConfirmed());
    }
}