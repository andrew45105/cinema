<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\CinemaSeat;
use AppBundle\Entity\Seance;
use AppBundle\Entity\User;
use AppBundle\Entity\UserOrder;
use Tests\BaseTestCase;

/**
 * Class UserOrderTest
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class UserOrderTest extends BaseTestCase
{
    /**
     * @var UserOrder
     */
    private $userOrder;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->userOrder = new UserOrder();
    }

    /**
     * Tests construct
     */
    public function testConstruct()
    {
        self::assertInstanceOf(UserOrder::class, new UserOrder());
    }

    /**
     * Tests get id
     *
     * @covers \AppBundle\Entity\UserOrder::getId()
     */
    public function testGetId()
    {
        $this->setValueToProperty($this->userOrder, 'id', 1);

        $id = $this->userOrder->getId();
        self::assertInternalType('int', $id);
        self::assertEquals(1, $id);
    }

    /**
     * Tests set and get user
     *
     * @covers \AppBundle\Entity\UserOrder::setUser()
     * @covers \AppBundle\Entity\UserOrder::getUser()
     */
    public function testSetGetUser()
    {
        $newUser = new User([
            'username' => 'some name',
        ]);
        self::assertInstanceOf(UserOrder::class, $this->userOrder->setUser($newUser));

        $user = $this->userOrder->getUser();
        self::assertInstanceOf(User::class, $user);
        self::assertEquals($newUser->getUsername(), $user->getUsername());
    }

    /**
     * Tests set and get seance
     *
     * @covers \AppBundle\Entity\UserOrder::setSeance()
     * @covers \AppBundle\Entity\UserOrder::getSeance()
     */
    public function testSetGetSeance()
    {
        $dateTime = new \DateTime();
        $newSeance = new Seance([
            'showingAt' => $dateTime,
        ]);
        self::assertInstanceOf(UserOrder::class, $this->userOrder->setSeance($newSeance));

        $seance = $this->userOrder->getSeance();
        self::assertInstanceOf(Seance::class, $seance);
        self::assertEquals(
            $newSeance->getShowingAt()->getTimestamp(),
            $seance->getShowingAt()->getTimestamp()
        );
    }

    /**
     * Tests set and get cinema seat
     *
     * @covers \AppBundle\Entity\UserOrder::setCinemaSeat()
     * @covers \AppBundle\Entity\UserOrder::getCinemaSeat()
     */
    public function testSetGetCinemaSeat()
    {
        $newSeat = new CinemaSeat([
            'seatNumber' => 'A1',
        ]);
        self::assertInstanceOf(UserOrder::class, $this->userOrder->setCinemaSeat($newSeat));

        $seat = $this->userOrder->getCinemaSeat();
        self::assertInstanceOf(CinemaSeat::class, $seat);
        self::assertEquals($newSeat->getSeatNumber(), $seat->getSeatNumber());
    }

    /**
     * Tests set and get spectator type
     *
     * @covers \AppBundle\Entity\UserOrder::setSpectatorType()
     * @covers \AppBundle\Entity\UserOrder::getSpectatorType()
     */
    public function testSetGetSpectatorType()
    {
        $spectatorType = 'some type';
        self::assertInstanceOf(UserOrder::class, $this->userOrder->setSpectatorType($spectatorType));
        self::assertEquals($this->userOrder->getSpectatorType(), $spectatorType);
    }

    /**
     * Tests set and get status
     *
     * @covers \AppBundle\Entity\UserOrder::setStatus()
     * @covers \AppBundle\Entity\UserOrder::getStatus()
     */
    public function testSetGetStatus()
    {
        self::assertEquals($this->userOrder->getStatus(), UserOrder::STATUSES[0]);

        $status = 'some status';
        self::assertInstanceOf(UserOrder::class, $this->userOrder->setStatus($status));
        self::assertEquals($this->userOrder->getStatus(), UserOrder::STATUSES[0]);

        $status = UserOrder::STATUSES[1];
        self::assertInstanceOf(UserOrder::class, $this->userOrder->setStatus($status));
        self::assertEquals($this->userOrder->getStatus(), UserOrder::STATUSES[1]);
    }
}