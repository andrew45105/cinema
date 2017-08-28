<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Film;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadFilmData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadFilmData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $genreComedy = $this->getReference('Comedy');
        $genreAction = $this->getReference('Action');
        $genreDrama = $this->getReference('Drama');
        $genreThriller = $this->getReference('Thriller');

        $films = [
            'film_1' => new Film([
                'title' => 'Film 1',
                'description' => 'some description 1',
                'duration' => 120,
                'yearOfMake' => 2017,
                'links' => [
                    'idmb' => 'http://film1.com'
                ],
            ]),
            'film_2' => new Film([
                'title' => 'Film 2',
                'description' => 'some description 2',
                'duration' => 112,
                'yearOfMake' => 1965,
            ]),
            'film_3' => new Film([
                'type' => 'TYPE_FILM',
                'title' => 'Film 3',
                'description' => 'some description 3',
                'duration' => 98,
                'minAge' => 12,
                'yearOfMake' => 2001,
            ]),
            'film_4' => new Film([
                'type' => 'TYPE_DOCUMENTARY',
                'title' => 'Film 4',
                'description' => 'some description 4',
                'duration' => 65,
                'minAge' => 11,
                'yearOfMake' => 2012,
            ]),
            'film_5' => new Film([
                'title' => 'Film 5',
                'description' => 'some description 5',
                'duration' => 104,
                'minAge' => 16,
                'yearOfMake' => 2015,
                'links' => [
                    'idmb' => 'http://film5.com'
                ],
            ]),
        ];

        $films['film_1']
            ->addGenre($genreComedy)
            ->addGenre($genreAction);
        $films['film_2']
            ->addGenre($genreAction)
            ->addGenre($genreThriller);
        $films['film_3']
            ->addGenre($genreDrama);
        $films['film_4']
            ->addGenre($genreComedy);

        foreach ($films as $filmKey => $film) {
            $manager->persist($film);
            $this->addReference($filmKey, $film);
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
        return 5;
    }
}