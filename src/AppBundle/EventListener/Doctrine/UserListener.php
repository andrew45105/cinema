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

        if ($entity->getConfirmCode()) {
            /* encode confirm code */
            $this->encodeField($entity, 'confirmCode');
            /* set confirm code created at */
            $entity->setConfirmCodeCreatedAt(new \DateTime());
        }
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

        if ($event->hasChangedField('confirmCode')) {
            /* encode new confirm code */
            $this->encodeField($entity, 'confirmCode');
            /* set confirm code created at */
            $event->setNewValue('confirmCodeCreatedAt', new \DateTime());
        }

        if ($event->hasChangedField('password')) {
            /* encode new plain password */
            $this->encodeField($entity, 'password');
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

        $userClass = new \ReflectionClass(User::class);
        $fieldValue = $userClass->getMethod('get' . ucfirst($fieldToEncode))->invokeArgs($user, []);

        $encodedFieldValue = $encoder->encodePassword($fieldValue, $user->getSalt());
        $userClass->getMethod('set' . ucfirst($fieldToEncode))->invokeArgs($user, [$encodedFieldValue]);
    }
}