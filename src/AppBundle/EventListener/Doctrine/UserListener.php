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
        $this->encodeAuthCode($entity);
    }

    /**
     * @param PreUpdateEventArgs $event
     */
    public function preUpdate(PreUpdateEventArgs $event)
    {
        if ($event->hasChangedField('authCode')) {
            $event->setNewValue('authCodeUpdatedAt', new \DateTime());
        }
    }

    /**
     * Gets encoded auth_code of an user
     *
     * @param User $user
     * @return void
     */
    private function encodeAuthCode(User $user)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        $encodedCode = $encoder->encodePassword($user->getAuthCode(), $user->getSalt());
        $user->setAuthCode($encodedCode);
    }
}