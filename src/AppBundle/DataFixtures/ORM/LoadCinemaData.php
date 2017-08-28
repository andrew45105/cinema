<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Cinema;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadCinemaData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadCinemaData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $moscow = $this->getReference('Moscow');
        $saintPetersburg = $this->getReference('Saint Petersburg');
        $yekaterinburg = $this->getReference('Yekaterinburg');

        $cinemas = [
            'cinema_msk_1' => new Cinema([
                'name' => 'Иллюзион',
                'locality' => $moscow,
                'address' => 'Котельническая наб., 1/15',
                'contacts' => [
                    '+7 (495) 915 43 39',
                    '+7 (495) 915 43 53'
                ],
                'confirmed' => true,
            ]),
            'cinema_msk_2' => new Cinema([
                'name' => 'Пионер',
                'locality' => $moscow,
                'address' => 'Кутузовский просп., 21',
                'contacts' => [
                    '+7 (499) 240 52 40'
                ],
                'confirmed' => true,
            ]),
            'cinema_msk_3' => new Cinema([
                'name' => 'Кинозал ГУМа',
                'locality' => $moscow,
                'address' => 'Красная пл., 3, ГУМ',
                'contacts' => [
                    '+7 (495) 788 43 43',
                    '+7 (495) 620 30 62'
                ],
                'confirmed' => true,
            ]),
            'cinema_msk_4' => new Cinema([
                'name' => 'Not Confirmed',
                'locality' => $moscow,
                'address' => 'Some Address',
            ]),
            'cinema_spb_1' => new Cinema([
                'name' => 'Родина',
                'locality' => $saintPetersburg,
                'address' => 'Караванная, 12',
                'contacts' => [
                    '+7 (812) 571 61 31',
                    '+7 (812) 314 28 27'
                ],
                'confirmed' => true,
            ]),
            'cinema_spb_2' => new Cinema([
                'name' => 'Аврора',
                'locality' => $saintPetersburg,
                'address' => 'Невский просп., 60',
                'contacts' => [
                    '+7 (812) 315 52 54',
                    '+7 (812) 942 80 20'
                ],
                'confirmed' => true,
            ]),
            'cinema_ekb_1' => new Cinema([
                'name' => 'Синема Парк Алатырь',
                'locality' => $yekaterinburg,
                'address' => 'Малышева, 5, «Алатырь»',
                'confirmed' => true,
            ]),
        ];

        foreach ($cinemas as $cinemaKey => $cinema) {
            $manager->persist($cinema);
            $this->addReference($cinemaKey, $cinema);
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
        return 3;
    }
}