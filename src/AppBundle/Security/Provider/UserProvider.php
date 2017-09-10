<?php

namespace AppBundle\Security\Provider;

use AppBundle\Entity\User;
use AppBundle\Repository\DefaultRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Serializer\Exception\UnsupportedException;

/**
 * Class UserProvider
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class UserProvider implements UserProviderInterface
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var DefaultRepository
     */
    protected $userRepository;

    /**
     * UserProvider constructor.
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @param DefaultRepository $repository
     */
    public function setUserRepository(DefaultRepository $repository)
    {
        $this->userRepository = $repository;
    }

    /**
     * @param string $username
     * @return null|User
     */
    public function loadUserByUsername($username): ?User
    {
        $user = $this->userRepository->findOneBy(['username' => $username]);
        if (null === $user) {
            $message = sprintf(
                'Unable to find an active User object identified by "%s"',
                $username
            );
            throw new NotFoundHttpException($message);
        }
        return $user;
    }

    /**
     * @param UserInterface $user
     * @return null|User
     */
    public function refreshUser(UserInterface $user): ?User
    {
        $class = get_class($user);
        if (false == $this->supportsClass($class)) {
            throw new UnsupportedException(
                sprintf(
                    'Instances of "%s" are not supported',
                    $class
                )
            );
        }
        return $this->userRepository->find($user->getId());
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class): bool
    {
        return $this->class === $class
            || is_subclass_of($class, $this->class);

    }
}