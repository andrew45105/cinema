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
        $authCode = $this->container->getParameter('test_users_auth_code');
        $userService = $this->container->get('app.service.entity.user');

        $users = [
            new User([
                'phone' => '+1111',
                'authCode' => $authCode,
                'firstName' => 'Mike',
                'lastName' => 'Doe',
                'locality' => $this->getReference('Moscow'),
                'enabled' => true,
            ]),
            new User([
                'phone' => '+2222',
                'authCode' => $authCode,
                'firstName' => 'John',
                'lastName' => 'Smith',
                'locality' => $this->getReference('Saint Petersburg'),
                'enabled' => true,
            ]),
            new User([
                'phone' => '+3333',
                'authCode' => $authCode,
                'firstName' => 'Miguel',
                'enabled' => true,
            ]),
            new User([
                'phone' => '+4444',
                'authCode' => $authCode,
                'enabled' => true,
            ]),
            new User([
                'phone' => '+5555',
                'authCode' => $authCode,
                'enabled' => true,
            ]),
        ];

        $users[2]->addRole('ROLE_MANAGER');
        $users[3]->addRole('ROLE_MANAGER');
        $users[4]->addRole('ROLE_ADMIN');

        foreach ($users as $user) {
            $userService->encodeAuthCode($user);
            $manager->persist($user);
            $this->addReference('user_' . $user->getPhone(), $user);
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
        return 8;
    }
}