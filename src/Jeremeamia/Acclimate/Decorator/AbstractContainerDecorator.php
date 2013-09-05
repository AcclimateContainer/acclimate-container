<?php

namespace Jeremeamia\Acclimate\Decorator;

use Jeremeamia\Acclimate\ContainerInterface;

abstract class AbstractContainerDecorator implements ContainerInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        return $this->container->get($name);
    }

    public function has($name)
    {
        return $this->container->has($name);
    }
}
