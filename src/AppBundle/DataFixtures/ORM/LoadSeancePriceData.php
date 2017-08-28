<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\SeancePrice;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadSeancePriceData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadSeancePriceData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $seances = [
            $this->getReference('seance_1'),
            $this->getReference('seance_2'),
            $this->getReference('seance_3'),
            $this->getReference('seance_4'),
            $this->getReference('seance_5'),
            $this->getReference('seance_6'),
        ];

        $prices = [
            new SeancePrice(['price' => 240, 'spectatorType' => 'grown']),
            new SeancePrice(['price' => 145, 'spectatorType' => 'children']),
            new SeancePrice(['price' => 180, 'spectatorType' => 'grown']),
            new SeancePrice(['price' => 110, 'spectatorType' => 'children']),
            new SeancePrice(['price' => 320]),
            new SeancePrice(['price' => 250]),
            new SeancePrice(['price' => 320]),
            new SeancePrice(['price' => 250]),
        ];

        $seances[0]
            ->addSeancePrice($prices[0])
            ->addSeancePrice($prices[1]);
        $seances[1]
            ->addSeancePrice($prices[2])
            ->addSeancePrice($prices[3]);
        $seances[2]
            ->addSeancePrice($prices[4]);
        $seances[3]
            ->addSeancePrice($prices[5]);
        $seances[4]
            ->addSeancePrice($prices[6]);
        $seances[5]
            ->addSeancePrice($prices[7]);

        foreach ($prices as $price) {
            $manager->persist($price);
        }

        foreach ($seances as $seance) {
            $manager->persist($seance);
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
        return 7;
    }
}