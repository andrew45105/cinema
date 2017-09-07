<?php

namespace AppBundle\Service\Entity;

use AppBundle\Entity\User;
use AppBundle\Repository\DefaultRepository;
use Doctrine\ORM\Query;
use AppBundle\Service\SmsService;
use RonteLtd\CommonBundle\Service\AbstractBaseService;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserService
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class UserService extends AbstractBaseService
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @var SmsService
     */
    private $smsService;

    /**
     * @var DefaultRepository
     */
    private $localityRepository;

    /**
     * @var array
     */
    private $usersRoles;

    /**
     * UserService constructor.
     *
     * @param ValidatorInterface $validator
     * @param array$roles
     */
    public function __construct(ValidatorInterface $validator, array $roles)
    {
        $this->usersRoles = $roles;

        parent::__construct($validator);
    }

    /**
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function setEncoderFactory(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param SmsService $smsService
     */
    public function setSmsService(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * @param DefaultRepository $repository
     */
    public function setLocalityRepository(DefaultRepository $repository)
    {
        $this->localityRepository = $repository;
    }

    /**
     * Creates an user
     *
     * @param array $data
     * @return User
     * @throws ConflictHttpException
     */
    public function create(array $data): User
    {
        if ($this->getRepository()->findOneBy(['username' => $data['username']])) {
            throw new ConflictHttpException(
                "User with username '{$data['username']}'' already exists");
        }

        $this->prepareUserData($data);

        $user = new User($data);
        $user->setEnabled(true);

        return $this->save($user);
    }

    /**
     * Creates confirm code for user
     *
     * @param User $user
     * @return User
     */
    public function createConfirmCode(User $user): User
    {
        if (!$user->getPhone()) {
            throw new BadRequestHttpException('User must have a phone number');
        }

        $confirmCode = $this->generateConfirmCode();
        $user->setConfirmCode($confirmCode);

        /**
         * @ToDo Sending confirm code to user phone (remove this stub on production)
         */
        //$this->smsService->send($user->getPhone(), $confirmCode);

        return $this->save($user);
    }

    /**
     * Confirms user
     *
     * @param User $user
     * @param string $confirmCode
     * @return User
     * @throws BadRequestHttpException
     */
    public function confirm(User $user, string $confirmCode): User
    {
        $this->checkUserCanBeConfirmed($user);

        if ($this->isValidConfirmCode($user, $confirmCode)) {
            $user->setConfirmed(true);
        } else {
            throw new BadRequestHttpException(
                "Invalid confirmation code - {$confirmCode}");
        }
        return $user;
    }

    /**
     * Updates an user
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data)
    {
        $this->prepareUserData($data);
        $user->fromArray($data);

        return $this->save($user);
    }

    /**
     * Validates confirm code
     *
     * @param User $user
     * @param $confirmCode
     * @return bool
     */
    public function isValidConfirmCode(User $user, string $confirmCode): bool
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        return $encoder->isPasswordValid(
            $user->getConfirmCode(),
            $confirmCode,
            $user->getSalt()
        );
    }

    /**
     * Gets query of users
     *
     * @return Query
     */
    public function getQuery(): Query
    {
        $qb = $this->getRepository()->createQueryBuilder('u');
        $query = $qb->getQuery();

        return $query->useResultCache(true)
            ->useQueryCache(true)
            ->setResultCacheId(User::NAMESPACE);
    }

    /**
     * Generates confirm code
     *
     * @param int $digits
     * @return int
     */
    private function generateConfirmCode(int $digits = 6): int
    {
        return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }

    /**
     * Prepare user data
     *
     * @param array $data
     */
    private function prepareUserData(array &$data)
    {
        if ($data['locality']) {
            if (!$locality = $this->localityRepository->find($data['locality'])) {
                throw new NotFoundHttpException(
                    "Locality with id {$data['locality']} not found");
            }
            $data['locality'] = $locality;
        }
    }

    /**
     * Check user can be confirmed
     *
     * @param User $user
     * @throws AccessDeniedHttpException
     */
    private function checkUserCanBeConfirmed(User $user)
    {
        $confirmTime = User::CONFIRM_CODE_LIMIT_MINUTES;

        $userCanConfirmAt = $user
            ->getConfirmCodeCreatedAt()
            ->add(new \DateInterval("PT{$confirmTime}M"));

        $now = new \DateTime();

        if ($now > $userCanConfirmAt) {
            throw new AccessDeniedHttpException(
                "Confirmation time ({$confirmTime} minutes) is over");
        }
    }

    /**
     * Check roles data
     *
     * @param array $roles
     * @throws BadRequestHttpException
     */
    private function checkRolesData(array $roles)
    {
        foreach ($roles as $role) {
            if (!is_string($role)) {
                throw new BadRequestHttpException('Each role must be a string');
            }
        }
        if ($roles !== array_intersect(array_keys($this->usersRoles), $roles)) {
            throw new BadRequestHttpException('Incorrect roles array');
        }
    }
}