<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Api\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Api\Container\NotFoundException as AcclimateException;
use Pimple;

/**
 * An adapter from a Pimple Container to the standardized ContainerInterface
 */
class PimpleContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var Pimple A Pimple Container
     */
    private $container;

    /**
     * @param Pimple $container A Pimple Container
     */
    public function __construct(Pimple $container)
    {
        $this->container = $container;
    }

    public function get($identifier)
    {
        try {
            return $this->container[$identifier];
        } catch (\InvalidArgumentException $prev) {
            throw new AcclimateException("There is no item in the container for \"{$identifier}\".", 0, $prev);
        }
    }

    public function has($identifier)
    {
        return isset($this->container[$identifier]);
    }
}
