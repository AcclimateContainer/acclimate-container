<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Api\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Api\Container\NotFoundException as AcclimateException;

/**
 * An adapter from an object implementing ArrayAccess to the standardized ContainerInterface
 */
class ArrayContainerAdapter implements AcclimateContainerInterface
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

    public function get($identifier)
    {
        try {
            if (isset($this->container[$identifier])) {
                return $this->container[$identifier];
            } else {
                $prev = null;
            }
        } catch (\Exception $prev) {
            // Do nothing, and allow the AcclimateException to be thrown
        }

        throw new AcclimateException("There is no item in the container for \"{$identifier}\".", 0, $prev);
    }

    public function has($identifier)
    {
        return isset($this->container[$identifier]);
    }
}
