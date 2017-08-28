<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class AbstractBaseFixture
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
abstract class AbstractBaseFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $kernel = $this->container->get('kernel');

        if (in_array($kernel->getEnvironment(), $this->getEnvironments())) {
            $this->doLoad($manager);
        }
    }

    /**
     * Performs the actual fixtures loading.
     *
     * @see \Doctrine\Common\DataFixtures\FixtureInterface::load()
     * @param ObjectManager $manager
     */
    abstract protected function doLoad(ObjectManager $manager): void;

    /**
     * Returns the list of environments.
     *
     * @return array (The name of the environments)
     */
    abstract protected function getEnvironments(): array;
}