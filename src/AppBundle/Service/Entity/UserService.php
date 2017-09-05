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
    public function create(array $data)
    {
        if ($this->getRepository()->findOneBy(['phone' => $data['phone']])) {
            throw new ConflictHttpException(
                "User with phone '{$data['phone']}'' already exists");
        }

        $user = new User($data);
        $user->setEnabled(true);
        $rawAuthCode = $this->generateAuthCode();
        $user->setAuthCode($rawAuthCode);

        /**
         * @ToDo Sending auth code to user phone (remove this stub on production)
         */
        //$this->smsService->send($user->getPhone(), $rawAuthCode);

        return $this->save($user);
    }

    /**
     * Creates new auth code for existing user
     *
     * @param string $phone
     * @return User
     */
    public function createAuthCode(string $phone)
    {
        if (!$user = $this->getRepository()->findOneBy(['phone' => $phone])) {
            throw new ConflictHttpException(
                "User with phone '{$phone}' does not exists");
        }

        $this->checkUserCanUpdateAuthCode($user);

        $rawAuthCode = $this->generateAuthCode();
        $user->setAuthCode($rawAuthCode);

        /**
         * @ToDo Sending auth code to user phone (remove this stub on production)
         */
        //$this->smsService->send($user->getPhone(), $rawAuthCode);

        return $this->save($user);
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
        if ($data['locality']) {
            if (!$locality = $this->localityRepository->find($data['locality'])) {
                throw new NotFoundHttpException(
                    "Locality with id {$data['locality']} not found");
            }
            $data['locality'] = $locality;
        }
        if ($data['roles']) {
            if (!in_array('ROLE_ADMIN', $user->getRoles())) {
                throw new AccessDeniedHttpException('You can\'t change user role');
            }
            $this->checkRolesData($data['roles']);
        }
        if (isset($data['enabled'])) {
            if (!in_array('ROLE_ADMIN', $user->getRoles())) {
                throw new AccessDeniedHttpException('You can\'t enable or disable user');
            }
        }
        $user->fromArray($data);

        return $this->save($user);
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
     * Generates auth code
     *
     * @param int $digits
     * @return int
     */
    private function generateAuthCode(int $digits = 8): int
    {
        return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }

    /**
     * Check user can update auth code
     *
     * @param User $user
     * @throws BadRequestHttpException
     */
    private function checkUserCanUpdateAuthCode(User $user)
    {
        $codeCanUpdateAt = $user
            ->getAuthCodeUpdatedAt()
            ->add(new \DateInterval('P' . User::CODE_UPDATED_LIMIT_HOURS . 'H'));

        $now = new \DateTime();

        if ($now < $codeCanUpdateAt) {
            $timeNeedWait = $now
                ->diff($codeCanUpdateAt)
                ->format('%d days, %h hours, %i minutes');
            throw new BadRequestHttpException(
                'You can not update your code so frequently, please, wait ' . $timeNeedWait);
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