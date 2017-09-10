<?php

namespace AppBundle\EventListeners;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * Class ExceptionListener
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class ExceptionListener
{
    /**
     * @var string
     */
    private $environment;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * ExceptionNormalizer constructor.
     * @param string $environment
     * @param Serializer $serializer
     */
    public function __construct(string $environment, Serializer $serializer)
    {
        $this->environment = $environment;
        $this->serializer = $serializer;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $result = [
            'error' => [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]
        ];

        if (in_array($this->environment, ['dev', 'test'])) {
            $result['error']['trace'] = $exception->getTraceAsString();
        }

        $response = new Response();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $result['error']['code'] = $exception->getStatusCode();
            $response->headers->replace($exception->getHeaders());
        } else {
            $statusCode = $exception->getCode() != 0 ? $exception->getCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->setStatusCode($statusCode);
        }

        $result = $this->serializer->serialize($result, 'json');
        $response->setContent($result);

        $event->setResponse($response);
    }
}