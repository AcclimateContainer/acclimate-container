<?php

namespace Acclimate\Container\Adapter;

use Psr\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;

/**
 * An adapter from an object implementing ArrayAccess to the standardized ContainerInterface
 */
class ArrayAccessContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var \ArrayAccess A container object that implements ArrayAccess
     */
    private $container;

    /**
     * @param \ArrayAccess $container A container object that implements ArrayAccess
     */
    public function __construct(\ArrayAccess $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        if (isset($this->container[$id])) {
            try {
                return $this->container[$id];
            } catch (\Exception $prev) {
                throw AcclimateContainerException::fromPrevious($id, $prev);
            }
        } else {
            throw AcclimateNotFoundException::fromPrevious($id);
        }
    }

    public function has($id): bool
    {
        return isset($this->container[$id]);
    }
}
