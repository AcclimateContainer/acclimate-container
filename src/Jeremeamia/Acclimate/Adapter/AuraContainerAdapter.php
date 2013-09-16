<?php

namespace Jeremeamia\Acclimate\Adapter;

use Aura\Di\Exception\ServiceNotFound;
use Aura\Di\ContainerInterface;
use Jeremeamia\Acclimate\ContainerInterface as AcclimateContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException as AcclimateException;

/**
 * An adapter from an Aura DIC to the standardized ContainerInterface
 */
class AuraContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var ContainerInterface An Aura DIC
     */
    private $container;

    /**
     * @param ContainerInterface $container An Aura DIC
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (ServiceNotFound $prev) {
            throw AcclimateException::fromName($name, $prev);
        }
    }

    public function has($name)
    {
        return $this->container->has($name);
    }
}
