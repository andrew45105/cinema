<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\CinemaSeat;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadCinemaSeatData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadCinemaSeatData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $rows = ['A', 'B', 'C', 'D'];
        $seatNumbers = [];

        foreach ($rows as $row) {
            for ($i = 1; $i < 11; $i++) {
                $seatNumbers[] = $row . $i;
            }
        }

        $cinemas = [
            'cinema_msk_1' => $this->getReference('cinema_msk_1'),
            'cinema_msk_2' => $this->getReference('cinema_msk_2'),
            'cinema_msk_3' => $this->getReference('cinema_msk_3'),
            'cinema_msk_4' => $this->getReference('cinema_msk_4'),
            'cinema_spb_1' => $this->getReference('cinema_spb_1'),
            'cinema_spb_2' => $this->getReference('cinema_spb_2'),
            'cinema_ekb_1' => $this->getReference('cinema_ekb_1'),
        ];

        foreach ($cinemas as $cinemaKey => $cinema) {
            foreach ($seatNumbers as $seatNumber) {
                $seat = new CinemaSeat(['seatNumber' => $seatNumber]);
                $cinema->addCinemaSeat($seat);
                $manager->persist($seat);
                $this->addReference($cinemaKey . '_' . $seat->getSeatNumber(), $seat);
            }
            $manager->persist($cinema);
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
        return 4;
    }
}