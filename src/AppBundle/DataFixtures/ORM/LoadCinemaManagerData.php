<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\CinemaManager;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadCinemaManagerData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadCinemaManagerData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $manager1 = $this->getReference('user_+3333');
        $manager2 = $this->getReference('user_+4444');

        $cinemasManagers = [
            new CinemaManager([
                'manager' => $manager1,
                'cinema' => $this->getReference('cinema_msk_1'),
                'confirmed' => true,
            ]),
            new CinemaManager([
                'manager' => $manager1,
                'cinema' => $this->getReference('cinema_msk_2'),
                'confirmed' => true,
            ]),
            new CinemaManager([
                'manager' => $manager1,
                'cinema' => $this->getReference('cinema_msk_3'),
                'confirmed' => true,
            ]),
            new CinemaManager([
                'manager' => $manager1,
                'cinema' => $this->getReference('cinema_msk_4'),
            ]),
            new CinemaManager([
                'manager' => $manager2,
                'cinema' => $this->getReference('cinema_spb_1'),
                'confirmed' => true,
            ]),
            new CinemaManager([
                'manager' => $manager2,
                'cinema' => $this->getReference('cinema_spb_2'),
                'confirmed' => true,
            ]),
            new CinemaManager([
                'manager' => $manager2,
                'cinema' => $this->getReference('cinema_ekb_1'),
                'confirmed' => true,
            ]),
        ];

        foreach ($cinemasManagers as $cinemaManager) {
            $manager->persist($cinemaManager);
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