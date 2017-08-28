<?php

namespace AppBundle\Service\Entity;

use AppBundle\Entity\User;
use AppBundle\Service\SmsService;
use RonteLtd\CommonBundle\Service\AbstractBaseService;
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
     * UserService constructor.
     *
     * @param EncoderFactoryInterface $encoderFactory
     * @param SmsService $smsService
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        SmsService $smsService,
        ValidatorInterface $validator)
    {
        $this->encoderFactory = $encoderFactory;
        $this->smsService = $smsService;

        parent::__construct($validator);
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        $user = new User($data);
        $user->setEnabled(true);
        $rawAuthCode = $this->generateAuthCode();
        $user->setAuthCode($rawAuthCode);
        $this->encodeAuthCode($user);

        $this->smsService->send($user->getPhone(), $rawAuthCode);

        return $this->save($user);
    }

    /**
     * Generates auth code
     *
     * @param int $digits
     * @return int
     */
    public function generateAuthCode(int $digits = 4): int
    {
        return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }

    /**
     * Gets encoded auth_code of an user
     *
     * @param User $user
     * @return void
     */
    public function encodeAuthCode(User $user)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        $encodedCode = $encoder->encodePassword($user->getAuthCode(), $user->getSalt());
        $user->setAuthCode($encodedCode);
    }
}