<?php

namespace AppBundle\Serializer\Normalizer;

use RonteLtd\CommonBundle\Exception\EntityValidateException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class ExceptionNormalizer
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class ExceptionNormalizer implements NormalizerInterface
{
    /**
     * @var string
     */
    private $environment;

    /**
     * ExceptionNormalizer constructor.
     * @param string $environment
     */
    public function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array()): array
    {
        $messages = [];

        if ($object instanceof EntityValidateException) {
            $messages = $object->getErrors();
        } elseif ($object instanceof \Exception) {
            $messages[] = $object->getMessage();
        }

        $result = [
            'error' => true,
            'error_messages' => $messages
        ];

        if (in_array($this->environment, ['dev', 'test'])) {
            $result['trace'] = $object->getTrace();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof \Exception;
    }
}