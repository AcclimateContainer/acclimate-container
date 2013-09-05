<?php

namespace Jeremeamia\Acclimate\Adapter;

use Jeremeamia\Acclimate\Acclimate;
use Jeremeamia\Acclimate\ContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException;

abstract class AbstractContainerAdapter implements ContainerInterface
{
    /**
     * @var mixed
     */
    protected $container;

    /**
     * @param object $container
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($container)
    {
        $expectedContainerFqcn = Acclimate::determineContainerFqcn(get_called_class());
        if ($container instanceof $expectedContainerFqcn) {
            $this->container = $container;
        } else {
            throw new \InvalidArgumentException("The container must be an instance of {$expectedContainerFqcn}.");
        }
    }

    /**
     * @param string          $name
     * @param \Exception|null $prev
     *
     * @throws ServiceNotFoundException
     */
    protected function handleMissingItem($name, \Exception $prev = null)
    {
        throw ServiceNotFoundException::fromName($name, $prev);
    }
}
