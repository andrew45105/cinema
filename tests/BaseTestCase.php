<?php

namespace Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class BaseTestCase
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
abstract class BaseTestCase extends WebTestCase
{
    /**
     * Sets value to private or protected property
     *
     * @param $class
     * @param $property
     * @param $value
     */
    protected function setValueToProperty($class, $property, $value): void
    {
        $reflectionProperty = new \ReflectionProperty($class, $property);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($class, $value);
    }

    /**
     * Invokes private/protected methods
     *
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return mixed
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}