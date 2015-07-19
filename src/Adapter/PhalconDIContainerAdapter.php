<?php

namespace Acclimate\Container\Adapter;

use Interop\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;

use Phalcon\DiInterface as PhalconDI;
use Phalcon\DI\Exception as PhalconDIException;

/**
 * An adapter from an object implementing Phalcon\DiInterface to the standardized ContainerInterface
 */
class PhalconDIContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var \Phalcon\DiInterface Phalcons DI container object
     */
    private $container;

    /**
     * @param \Phalcon\DiInterface $container
     */
    public function __construct(PhalconDI $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch(PhalconDIException $prev) {
            throw AcclimateNotFoundException::fromPrevious($id);
        } catch (\Exception $prev) {
            throw AcclimateContainerException::fromPrevious($id, $prev);
        }
    }

    public function has($id)
    {
        return isset($this->container[$id]);
    }
}
