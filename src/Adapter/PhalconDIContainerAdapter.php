<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Phalcon\DiInterface as PhalconDI;
use Phalcon\DI\Exception as PhalconDIException;
use Psr\Container\ContainerInterface;

/**
 * An adapter from an object implementing Phalcon\DiInterface to the standardized ContainerInterface
 */
class PhalconDIContainerAdapter implements ContainerInterface
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
        } catch (PhalconDIException $prev) {
            throw AcclimateNotFoundException::fromPrevious($id);
        } catch (\Exception $prev) {
            throw AcclimateContainerException::fromPrevious($id, $prev);
        }
    }

    public function has($id): bool
    {
        return isset($this->container[$id]);
    }
}
