<?php

namespace Jeremeamia\Acclimate\Adapter;

use Jeremeamia\Acclimate\ContainerInterface as AcclimateContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException as AcclimateException;
use Pimple;

class PimpleContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var Pimple
     */
    private $container;

    /**
     * @param Pimple $container
     */
    public function __construct(Pimple $container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        try {
            return $this->container[$name];
        } catch (\InvalidArgumentException $prev) {
            throw AcclimateException::fromName($name, $prev);
        }
    }

    public function has($name)
    {
        return isset($this->container[$name]);
    }
}
