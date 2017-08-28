<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Seance;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadSeanceData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadSeanceData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $seances = [
            'seance_1' => new Seance([
                'cinema' => $this->getReference('cinema_msk_1'),
                'film' => $this->getReference('film_1'),
                'showingAt' => (new \DateTime())->modify('+1 day'),
            ]),
            'seance_2' => new Seance([
                'cinema' => $this->getReference('cinema_msk_2'),
                'film' => $this->getReference('film_2'),
                'showingAt' => (new \DateTime())->modify('+2 days'),
            ]),
            'seance_3' => new Seance([
                'cinema' => $this->getReference('cinema_msk_3'),
                'film' => $this->getReference('film_2'),
                'showingAt' => (new \DateTime())->modify('-1 day'),
            ]),
            'seance_4' => new Seance([
                'cinema' => $this->getReference('cinema_spb_1'),
                'film' => $this->getReference('film_3'),
                'showingAt' => (new \DateTime())->modify('+1 day'),
            ]),
            'seance_5' => new Seance([
                'cinema' => $this->getReference('cinema_spb_2'),
                'film' => $this->getReference('film_4'),
                'showingAt' => (new \DateTime())->modify('+1 day'),
            ]),
            'seance_6' => new Seance([
                'cinema' => $this->getReference('cinema_ekb_1'),
                'film' => $this->getReference('film_5'),
                'showingAt' => (new \DateTime())->modify('+1 day'),
            ]),
        ];

        foreach ($seances as $seanceKey => $seance) {
            $manager->persist($seance);
            $this->addReference($seanceKey, $seance);
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
        return 6;
    }
}