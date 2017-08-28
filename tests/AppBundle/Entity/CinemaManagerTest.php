<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Cinema;
use AppBundle\Entity\CinemaManager;
use AppBundle\Entity\Locality;
use AppBundle\Entity\User;
use Tests\BaseTestCase;

/**
 * Class CinemaManagerTest
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class CinemaManagerTest extends BaseTestCase
{
    /**
     * @var CinemaManager
     */
    private $cinemaManager;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->cinemaManager = new CinemaManager();
    }

    /**
     * Tests construct
     */
    public function testConstruct()
    {
        self::assertInstanceOf(CinemaManager::class, new CinemaManager());
    }

    /**
     * Tests set and get cinema
     *
     * @covers \AppBundle\Entity\CinemaManager::setCinema()
     * @covers \AppBundle\Entity\CinemaManager::getCinema()
     */
    public function testSetGetCinema()
    {
        $newCinema = new Cinema([
            'name' => 'Some Cinema',
        ]);
        self::assertInstanceOf(CinemaManager::class, $this->cinemaManager->setCinema($newCinema));

        $cinema = $this->cinemaManager->getCinema();
        self::assertInstanceOf(Cinema::class, $cinema);
        self::assertEquals($newCinema->getName(), $cinema->getName());
    }

    /**
     * Tests set and get manager
     *
     * @covers \AppBundle\Entity\CinemaManager::setManager()
     * @covers \AppBundle\Entity\CinemaManager::getManager()
     */
    public function testSetGetManager()
    {
        $newManager = (new User())->fromArray([
            'username' => 'user',
        ]);
        self::assertInstanceOf(CinemaManager::class, $this->cinemaManager->setManager($newManager));

        $manager = $this->cinemaManager->getManager();
        self::assertInstanceOf(User::class, $manager);
        self::assertEquals($newManager->getUsername(), $manager->getUsername());
    }

    /**
     * Tests set and is confirmed
     *
     * @covers \AppBundle\Entity\CinemaManager::setConfirmed()
     * @covers \AppBundle\Entity\CinemaManager::isConfirmed()
     */
    public function testSetIsConfirmed()
    {
        self::assertFalse($this->cinemaManager->isConfirmed());
        self::assertInstanceOf(CinemaManager::class, $this->cinemaManager->setConfirmed(true));
        self::assertTrue($this->cinemaManager->isConfirmed());
    }
}