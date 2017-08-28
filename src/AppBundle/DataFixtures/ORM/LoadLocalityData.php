<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Locality;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadLocalityData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadLocalityData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $localities = [
            new Locality([
                'name' => 'Moscow',
                'latitude' => 55.75,
                'longitude' => 37.61,
            ]),
            new Locality([
                'name' => 'Saint Petersburg',
                'latitude' => 59.89,
                'longitude' => 30.26,
            ]),
            new Locality([
                'name' => 'Yekaterinburg',
                'latitude' => 56.85,
                'longitude' => 60.6,
            ]),
        ];

        foreach ($localities as $locality) {
            $manager->persist($locality);
            $this->addReference($locality->getName(), $locality);
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
        return 1;
    }
}