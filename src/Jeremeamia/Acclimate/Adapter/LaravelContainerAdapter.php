<?php

namespace Jeremeamia\Acclimate\Adapter;

use Illuminate\Container\Container;
use Jeremeamia\Acclimate\ContainerInterface as AcclimateContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException as AcclimateException;

class LaravelContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        try {
            return $this->container->make($name);
        } catch (\Exception $prev) {
            throw AcclimateException::fromName($name, $prev);
        }
    }

    public function has($name)
    {
        return $this->container->bound($name);
    }
}
