<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Cinema;
use AppBundle\Entity\CinemaManager;
use AppBundle\Entity\CinemaSeat;
use AppBundle\Entity\Locality;
use AppBundle\Entity\User;
use AppBundle\Entity\UserOrder;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Tests\BaseTestCase;

/**
 * Class UserTest
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class UserTest extends BaseTestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->user = new User();
    }

    /**
     * Tests construct
     */
    public function testConstruct()
    {
        self::assertInstanceOf(User::class, new User());
    }

    /**
     * Tests get id
     *
     * @covers \AppBundle\Entity\User::getId()
     */
    public function testGetId()
    {
        $this->setValueToProperty($this->user, 'id', 1);

        $id = $this->user->getId();
        self::assertInternalType('int', $id);
        self::assertEquals(1, $id);
    }

    /**
     * Tests set and get username
     *
     * @covers \AppBundle\Entity\User::setUsername()
     * @covers \AppBundle\Entity\User::getUsername()
     */
    public function testSetGetUsername()
    {
        $username = 'Andrew';
        self::assertInstanceOf(User::class, $this->user->setUsername($username));
        self::assertEquals($this->user->getUsername(), $username);
    }

    /**
     * Tests set and get password
     *
     * @covers \AppBundle\Entity\User::setPassword()
     * @covers \AppBundle\Entity\User::getPassword()
     */
    public function testSetGetPassword()
    {
        $password = 'abcd123';
        self::assertInstanceOf(User::class, $this->user->setPassword($password));
        self::assertEquals($this->user->getPassword(), $password);
    }

    /**
     * Tests set and get phone
     *
     * @covers \AppBundle\Entity\User::setPhone()
     * @covers \AppBundle\Entity\User::getPhone()
     */
    public function testSetGetPhone()
    {
        $phone = '12345678';
        self::assertInstanceOf(User::class, $this->user->setPhone($phone));
        self::assertEquals($this->user->getPhone(), $phone);
    }

    /**
     * Tests set and get confirm code
     *
     * @covers \AppBundle\Entity\User::setConfirmCode()
     * @covers \AppBundle\Entity\User::getConfirmCode()
     */
    public function testSetGetConfirmCode()
    {
        $confirmCode = 'some code';
        self::assertInstanceOf(User::class, $this->user->setConfirmCode($confirmCode));
        self::assertEquals($this->user->getConfirmCode(), $confirmCode);
    }

    /**
     * Tests set and get confirm code created at
     *
     * @covers \AppBundle\Entity\User::setConfirmCodeCreatedAt()
     * @covers \AppBundle\Entity\User::getConfirmCodeCreatedAt()
     */
    public function testSetGetConfirmCodeCreatedAt()
    {
        $dateTime = (new \DateTime())->modify('-1 day');
        self::assertNull($this->user->getConfirmCodeCreatedAt());
        self::assertInstanceOf(User::class, $this->user->setConfirmCodeCreatedAt($dateTime));
        self::assertEquals(
            $this->user->getConfirmCodeCreatedAt()->getTimestamp(),
            $dateTime->getTimestamp()
        );
    }

    /**
     * Tests get salt
     *
     * @covers \AppBundle\Entity\User::getSalt()
     */
    public function testGetSalt()
    {
        self::assertInternalType('string', $this->user->getSalt());
    }

    /**
     * Tests get roles
     *
     * @covers \AppBundle\Entity\User::getRoles()
     */
    public function testGetRoles()
    {
        self::assertInternalType('array', $this->user->getRoles());
        self::assertCount(1, $this->user->getRoles());
        self::assertEquals('ROLE_USER', $this->user->getRoles()[0]);
    }

    /**
     * @covers \AppBundle\Entity\User::addRole()
     * @covers \AppBundle\Entity\User::removeRole()
     */
    public function testAddRemoveRoles()
    {
        self::assertInstanceOf(User::class, $this->user->addRole('ROLE_ADMIN'));
        self::assertTrue(in_array('ROLE_ADMIN', $this->user->getRoles()));
        self::assertInstanceOf(User::class, $this->user->removeRole('ROLE_ADMIN'));
        self::assertFalse(in_array('ROLE_ADMIN', $this->user->getRoles()));
    }

    /**
     * Tests set and get first name
     *
     * @covers \AppBundle\Entity\User::setFirstName()
     * @covers \AppBundle\Entity\User::getFirstName()
     */
    public function testSetGetFirstName()
    {
        $firstName = 'some name';
        self::assertInstanceOf(User::class, $this->user->setFirstName($firstName));
        self::assertEquals($this->user->getFirstName(), $firstName);
    }

    /**
     * Tests set and get last name
     *
     * @covers \AppBundle\Entity\User::setLastName()
     * @covers \AppBundle\Entity\User::getLastName()
     */
    public function testSetGetLastName()
    {
        $lastName = 'some name';
        self::assertInstanceOf(User::class, $this->user->setLastName($lastName));
        self::assertEquals($this->user->getLastName(), $lastName);
    }

    /**
     * Tests set and get locality
     *
     * @covers \AppBundle\Entity\User::setLocality()
     * @covers \AppBundle\Entity\User::getLocality()
     */
    public function testSetGetLocality()
    {
        $newLocality = new Locality([
            'name' => 'some locality',
        ]);
        self::assertInstanceOf(User::class, $this->user->setLocality($newLocality));

        $locality = $this->user->getLocality();
        self::assertInstanceOf(Locality::class, $locality);
        self::assertEquals($newLocality->getName(), $locality->getName());
    }

    /**
     * Tests add cinema manager and get cinemas managers
     *
     * @covers \AppBundle\Entity\User::addCinemaManager()
     * @covers \AppBundle\Entity\User::getCinemasManagers()
     *
     * @return CinemaManager
     */
    public function testAddGetCinemasManagers()
    {
        $manager = new CinemaManager([
            'cinema' => new Cinema(['name' => 'some cinema']),
        ]);
        self::assertInstanceOf(User::class, $this->user->addCinemaManager($manager));

        $managers = $this->user->getCinemasManagers();
        self::assertInstanceOf(Collection::class, $managers);
        self::assertCount(1, $managers);
        self::assertInstanceOf(CinemaManager::class, $managers->first());
        self::assertEquals(
            $manager->getCinema()->getName(),
            $managers->first()->getCinema()->getName()
        );

        return $manager;
    }

    /**
     * Tests remove cinema manager and get cinemas managers
     *
     * @param CinemaManager $manager
     *
     * @covers \AppBundle\Entity\User::removeCinemaManager()
     * @covers \AppBundle\Entity\User::getCinemasManagers()
     * @depends testAddGetCinemasManagers
     */
    public function testRemoveGetCinemasManagers(CinemaManager $manager)
    {
        self::assertInstanceOf(User::class, $this->user->removeCinemaManager($manager));

        $managers = $this->user->getCinemasManagers();
        self::assertInstanceOf(Collection::class, $managers);
        self::assertCount(0, $managers);
    }

    /**
     * Tests add order and get orders
     *
     * @covers \AppBundle\Entity\User::addOrder()
     * @covers \AppBundle\Entity\User::getOrders()
     *
     * @return UserOrder
     */
    public function testAddGetOrders()
    {
        $order = new UserOrder([
            'cinemaSeat' => new CinemaSeat(['seatNumber' => 'A1']),
        ]);
        self::assertInstanceOf(User::class, $this->user->addOrder($order));

        $orders = $this->user->getOrders();
        self::assertInstanceOf(Collection::class, $orders);
        self::assertCount(1, $orders);
        self::assertInstanceOf(UserOrder::class, $orders->first());
        self::assertEquals(
            $order->getCinemaSeat()->getSeatNumber(),
            $orders->first()->getCinemaSeat()->getSeatNumber()
        );

        return $order;
    }

    /**
     * Tests remove order and get orders
     *
     * @param UserOrder $order
     *
     * @covers \AppBundle\Entity\User::removeOrder()
     * @covers \AppBundle\Entity\User::getOrders()
     * @depends testAddGetOrders
     */
    public function testRemoveGetOrders(UserOrder $order)
    {
        self::assertInstanceOf(User::class, $this->user->removeOrder($order));

        $orders = $this->user->getOrders();
        self::assertInstanceOf(Collection::class, $orders);
        self::assertCount(0, $orders);
    }

    /**
     * Tests set and is confirmed
     *
     * @covers \AppBundle\Entity\User::setConfirmed()
     * @covers \AppBundle\Entity\User::isConfirmed()
     */
    public function testSetIsConfirmed()
    {
        self::assertFalse($this->user->isConfirmed());
        self::assertInstanceOf(User::class, $this->user->setConfirmed(true));
        self::assertTrue($this->user->isConfirmed());
    }

    /**
     * Tests set and is enabled
     *
     * @covers \AppBundle\Entity\User::setEnabled()
     * @covers \AppBundle\Entity\User::isEnabled()
     */
    public function testSetIsEnabled()
    {
        self::assertFalse($this->user->isEnabled());
        self::assertInstanceOf(User::class, $this->user->setEnabled(true));
        self::assertTrue($this->user->isEnabled());
    }
}