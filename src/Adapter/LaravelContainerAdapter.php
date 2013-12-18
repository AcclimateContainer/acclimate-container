<?php

namespace Acclimate\Container\Adapter;

use Illuminate\Container\Container;
use Acclimate\Api\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Api\Container\NotFoundException as AcclimateException;

/**
 * An adapter from a Laravel Container to the standardized ContainerInterface
 */
class LaravelContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var Container A Laravel Container
     */
    private $container;

    /**
     * @param Container $container A Laravel Container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get($identifier)
    {
        try {
            return $this->container->make($identifier);
        } catch (\Exception $prev) {
            throw new AcclimateException("There is no item in the container for \"{$identifier}\".", 0, $prev);
        }
    }

    public function has($identifier)
    {
        return $this->container->bound($identifier);
    }
}
