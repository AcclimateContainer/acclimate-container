<?php

namespace Jeremeamia\Acclimate\Decorator;

use Jeremeamia\Acclimate\ContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException;

/**
 * A container decorator that changes the default behavior of throwing an exception when an item doesn't exist in the
 * container to instead execute a callback function
 */
class CallbackOnMissContainerDecorator implements ContainerInterface
{
    /**
     * @var ContainerInterface The decorated container
     */
    protected $container;

    /**
     * @var callback A callback function
     */
    private $callback;

    /**
     * @param ContainerInterface $container The container being decorated
     * @param callable           $callback  A callback function to be executed if an item in the container doesn't exist
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(ContainerInterface $container, $callback)
    {
        $this->container = $container;
        if (is_callable($callback)) {
            $this->callback = $callback;
        } else {
            throw new \InvalidArgumentException('The callback provided was not callable.');
        }
    }

    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (ServiceNotFoundException $e) {
            return call_user_func($this->callback, $name);
        }
    }

    public function has($name)
    {
        return $this->container->has($name);
    }
}
