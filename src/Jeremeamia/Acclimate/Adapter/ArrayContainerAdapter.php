<?php

namespace Jeremeamia\Acclimate\Adapter;

use ArrayAccess;
use Jeremeamia\Acclimate\ContainerInterface as AcclimateContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException as AcclimateException;

class ArrayContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var ArrayAccess
     */
    private $container;

    /**
     * @param ArrayAccess $container
     */
    public function __construct(ArrayAccess $container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        try {
            if (isset($this->container[$name])) {
                return $this->container[$name];
            } else {
                throw AcclimateException::fromName($name);
            }
        } catch (\Exception $prev) {
            throw AcclimateException::fromName($name, $prev);
        }
    }

    public function has($name)
    {
        return isset($this->container[$name]);
    }
}
