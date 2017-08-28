<?php

namespace AppBundle\Service;

use AppBundle\Repository\DefaultRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class AuthService
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class AuthService
{
    /**
     * @var DefaultRepository
     */
    private $userRepository;

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @var JWTEncoderInterface
     */
    private $jwtEncoder;

    /**
     * AuthService constructor.
     * @param DefaultRepository $userRepository
     * @param EncoderFactoryInterface $encoderFactory
     * @param JWTEncoderInterface $jwtEncoder
     */
    public function __construct(
        DefaultRepository $userRepository,
        EncoderFactoryInterface $encoderFactory,
        JWTEncoderInterface $jwtEncoder)
    {
        $this->userRepository = $userRepository;
        $this->encoderFactory = $encoderFactory;
        $this->jwtEncoder = $jwtEncoder;
    }


    /**
     * Gets auth token
     *
     * @param array $params
     * @return array
     *
     * @throws NotFoundHttpException
     * @throws AccessDeniedHttpException
     */
    public function getAuthToken(array $params): array
    {
        $phone = $params['phone'];
        $authCode = $params['auth_code'];

        $user = $this->userRepository->findOneBy(['phone' => $phone]);

        if (!$user) {
            throw new NotFoundHttpException("User with phone '{$phone}' not found");
        }

        $passwordEncoder = $this->encoderFactory->getEncoder($user);
        $rawAuthCode = $user->getAuthCode();
        $salt = $user->getSalt();

        if (!$passwordEncoder->isPasswordValid($rawAuthCode, $authCode, $salt)) {
            throw new AccessDeniedHttpException();
        }

        $token = $this->jwtEncoder->encode(['phone' => $user->getPhone()]);

        return [
            'token' => $token
        ];
    }
}