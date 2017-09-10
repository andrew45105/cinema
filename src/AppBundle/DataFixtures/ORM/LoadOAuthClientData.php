<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\OAuth\Client;
use Doctrine\Common\Persistence\ObjectManager;
use OAuth2\OAuth2;

/**
 * Class LoadOAuthClientData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadOAuthClientData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $client = new Client();
        $client->setRandomId('cro1at47sv4ks8cwk8swwg8o4soswkcokg48g4c0kg8k48008');
        $client->setSecret('4fgpwc3by9esgcsg4048cgc8kwss0o0g84000c44gcgk80osww');
        $client->setAllowedGrantTypes([OAuth2::GRANT_TYPE_USER_CREDENTIALS]);

        $manager->persist($client);
        $manager->flush();

        $this->addReference('client', $client);
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