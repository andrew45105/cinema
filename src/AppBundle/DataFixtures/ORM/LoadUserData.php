<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadUserData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $password = $this->container->getParameter('test_users_password');
        $confirmCode = $this->container->getParameter('test_users_confirm_code');

        $users = [
            new User([
                'username' => 'mike',
                'password' => $password,
                'phone' => '+1111',
                'confirmCode' => $confirmCode,
                'confirmCodeCreatedAt' => new \DateTime(),
                'firstName' => 'Mike',
                'lastName' => 'Doe',
                'locality' => $this->getReference('Moscow'),
                'confirmed' => true,
                'enabled' => true,
            ]),
            new User([
                'username' => 'jack',
                'password' => $password,
                'phone' => '+2222',
                'confirmCode' => $confirmCode,
                'confirmCodeCreatedAt' => new \DateTime(),
                'firstName' => 'Jack',
                'lastName' => 'Wilson',
                'locality' => $this->getReference('Saint Petersburg'),
                'confirmed' => true,
                'enabled' => true,
            ]),
            new User([
                'username' => 'john',
                'password' => $password,
                'phone' => '+3333',
                'firstName' => 'John',
                'lastName' => 'Smith',
                'locality' => $this->getReference('Saint Petersburg'),
                'enabled' => true,
            ]),
            new User([
                'username' => 'miguel',
                'password' => $password,
                'phone' => '+4444',
                'confirmCode' => $confirmCode,
                'confirmCodeCreatedAt' => new \DateTime(),
                'firstName' => 'Miguel',
                'confirmed' => true,
                'enabled' => true,
            ]),
            new User([
                'username' => 'user4',
                'password' => $password,
                'phone' => '+5555',
                'confirmCode' => $confirmCode,
                'confirmCodeCreatedAt' => new \DateTime(),
                'confirmed' => true,
                'enabled' => true,
            ]),
            new User([
                'username' => 'user5',
                'password' => $password,
                'phone' => '+6666',
                'confirmCode' => $confirmCode,
                'confirmCodeCreatedAt' => new \DateTime(),
                'confirmed' => true,
                'enabled' => true,
            ]),
        ];

        $users[3]->addRole('ROLE_MANAGER');
        $users[4]->addRole('ROLE_MANAGER');
        $users[5]->addRole('ROLE_ADMIN');

        foreach ($users as $user) {
            $manager->persist($user);
            $this->addReference($user->getUsername(), $user);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnvironments(): array
    {
        return ['dev', 'test'];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 9;
    }
}