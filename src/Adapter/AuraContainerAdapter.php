<?php

namespace Acclimate\Container\Adapter;

use Aura\Di\Exception\ServiceNotFound;
use Aura\Di\ContainerInterface;
use Acclimate\Api\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Api\Container\NotFoundException as AcclimateException;

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

    public function get($identifier)
    {
        try {
            return $this->container->get($identifier);
        } catch (ServiceNotFound $prev) {
            throw new AcclimateException("There is no item in the container for \"{$identifier}\".", 0, $prev);
        }
    }

    public function has($identifier)
    {
        return $this->container->has($identifier);
    }
}
