<?php

namespace Acclimate\Container\Adapter;

use Interop\Container\ContainerInterface as AcclimateContainerInterface;
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
        try {
            if (isset($this->container[$id])) {
                return $this->container[$id];
            } else {
                throw AcclimateNotFoundException::fromPrevious($id, null);
            }
        } catch (\Exception $prev) {
            throw AcclimateContainerException::fromPrevious($id, $prev);
        }
    }

    public function has($id)
    {
        return isset($this->container[$id]);
    }
}
