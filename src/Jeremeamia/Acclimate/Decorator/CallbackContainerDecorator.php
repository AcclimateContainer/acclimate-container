<?php

namespace Jeremeamia\Acclimate\Decorator;

use Jeremeamia\Acclimate\ContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException;

class CallbackContainerDecorator extends AbstractContainerDecorator
{
    /**
     * @var callback
     */
    private $callback;

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
}
