<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\UserOrder;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserOrderData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadUserOrderData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $userMike = $this->getReference('mike');
        $userJack = $this->getReference('jack');

        $seance1 = $this->getReference('seance_1');
        $seance2 = $this->getReference('seance_2');
        $seance3 = $this->getReference('seance_3');

        $orders = [
            new UserOrder([
                'user' => $userMike,
                'seance' => $seance1,
                'cinemaSeat' => $seance1->getCinema()->getCinemasSeats()->get(10),
                'spectatorType' => $seance1->getSeancesPrices()->first()->getSpectatorType(),
            ]),
            new UserOrder([
                'user' => $userMike,
                'seance' => $seance2,
                'cinemaSeat' => $seance2->getCinema()->getCinemasSeats()->get(21),
                'spectatorType' => $seance2->getSeancesPrices()->first()->getSpectatorType(),
            ]),
            new UserOrder([
                'user' => $userJack,
                'seance' => $seance3,
                'cinemaSeat' => $seance3->getCinema()->getCinemasSeats()->get(3),
                'spectatorType' => $seance3->getSeancesPrices()->first()->getSpectatorType(),
            ]),
            new UserOrder([
                'user' => $userJack,
                'seance' => $seance3,
                'cinemaSeat' => $seance3->getCinema()->getCinemasSeats()->get(7),
                'spectatorType' => $seance3->getSeancesPrices()->first()->getSpectatorType(),
                'status' => UserOrder::STATUSES[1],
            ]),
        ];

        foreach ($orders as $order) {
            $manager->persist($order);
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
        return 12;
    }
}