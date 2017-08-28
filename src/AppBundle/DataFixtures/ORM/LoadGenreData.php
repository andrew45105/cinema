<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Genre;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadGenreData
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LoadGenreData extends AbstractBaseFixture
{
    /**
     * {@inheritdoc}
     */
    protected function doLoad(ObjectManager $manager): void
    {
        $genres = [
            new Genre(['title' => 'Comedy']),
            new Genre(['title' => 'Action']),
            new Genre(['title' => 'Drama']),
            new Genre(['title' => 'Erotic']),
            new Genre(['title' => 'Thriller']),
            new Genre(['title' => 'Fantasy']),
        ];

        foreach ($genres as $genre) {
            $manager->persist($genre);
            $this->addReference($genre->getTitle(), $genre);
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
        return 2;
    }
}