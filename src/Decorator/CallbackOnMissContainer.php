<?php

namespace Acclimate\Container\Decorator;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\NotFoundException;

/**
 * A container decorator that changes the default behavior of throwing an exception when an item doesn't exist in the
 * container to instead execute a callback function
 */
class CallbackOnMissContainer extends AbstractContainerDecorator
{
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
        parent::__construct($container);
        if (is_callable($callback)) {
            $this->callback = $callback;
        } else {
            throw new \InvalidArgumentException('The callback provided was not callable.');
        }
    }

    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch (NotFoundException $e) {
            return call_user_func($this->callback, $id);
        }
    }
}
