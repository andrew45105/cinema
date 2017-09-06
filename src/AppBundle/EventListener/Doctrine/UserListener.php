<?php

namespace AppBundle\EventListener\Doctrine;

use AppBundle\Entity\User;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class UserListener
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class UserListener
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function setEncoderFactory(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        }
        /* encode plain password */
        $this->encodeField($entity, 'password');
    }

    /**
     * @param PreUpdateEventArgs $event
     */
    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getEntity();
        if (!$entity instanceof User) {
            return;
        }

        /* update confirmCodeCreatedAt field */
        if ($event->hasChangedField('confirmCode')) {
            $this->encodeField($entity, 'confirmCode');
            $event->setNewValue('confirmCodeCreatedAt', new \DateTime());
        }
    }

    /**
     * Encode some field's data of an user
     *
     * @param User $user
     * @param string $fieldToEncode
     * @return void
     */
    private function encodeField(User $user, string $fieldToEncode)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        /**
         * @ToDo add reflection
         */
        //$encodedField = $encoder->encodePassword($user->getPassword(), $user->getSalt());
        //$user->setPassword($encodedPassword);
    }
}