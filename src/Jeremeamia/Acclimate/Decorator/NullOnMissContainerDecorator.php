<?php

namespace Jeremeamia\Acclimate\Decorator;

use Jeremeamia\Acclimate\ContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException;

/**
 * A container decorator that changes the default behavior of throwing an exception when an item doesn't exist in the
 * container to instead return NULL
 */
class NullOnMissContainerDecorator implements ContainerInterface
{
    /**
     * @var ContainerInterface The decorated container
     */
    protected $container;

    /**
     * @param ContainerInterface $container The container being decorated
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (ServiceNotFoundException $e) {
            return null;
        }
    }

    public function has($name)
    {
        return $this->container->has($name);
    }
}
