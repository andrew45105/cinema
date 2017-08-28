<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Locality;
use Tests\BaseTestCase;

/**
 * Class LocalityTest
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LocalityTest extends BaseTestCase
{
    /**
     * @var Locality
     */
    private $locality;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->locality = new Locality();
    }

    /**
     * Tests construct
     */
    public function testConstruct()
    {
        self::assertInstanceOf(Locality::class, new Locality());
    }

    /**
     * Tests get id
     *
     * @covers \AppBundle\Entity\Locality::getId()
     */
    public function testGetId()
    {
        $this->setValueToProperty($this->locality, 'id', 1);

        $id = $this->locality->getId();
        self::assertInternalType('int', $id);
        self::assertEquals(1, $id);
    }

    /**
     * Tests set and get name
     *
     * @covers \AppBundle\Entity\Locality::setName()
     * @covers \AppBundle\Entity\Locality::getName()
     */
    public function testSetGetName()
    {
        $name = 'some name';
        self::assertInstanceOf(Locality::class, $this->locality->setName($name));
        self::assertEquals($this->locality->getName(), $name);
    }

    /**
     * Tests set and get latitude
     *
     * @covers \AppBundle\Entity\Locality::setLatitude()
     * @covers \AppBundle\Entity\Locality::getLatitude()
     */
    public function testSetGetLatitude()
    {
        $latitude = 56.789;
        self::assertInstanceOf(Locality::class, $this->locality->setLatitude($latitude));
        self::assertEquals($this->locality->getLatitude(), $latitude);
    }

    /**
     * Tests set and get longitude
     *
     * @covers \AppBundle\Entity\Locality::setLongitude()
     * @covers \AppBundle\Entity\Locality::getLongitude()
     */
    public function testSetGetLongitude()
    {
        $longitude = 41.45;
        self::assertInstanceOf(Locality::class, $this->locality->setLongitude($longitude));
        self::assertEquals($this->locality->getLongitude(), $longitude);
    }
}