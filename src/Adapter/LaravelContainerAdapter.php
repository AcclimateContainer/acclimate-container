<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Illuminate\Container\Container as LaravelContainerInterface;
use Interop\Container\ContainerInterface as AcclimateContainerInterface;

/**
 * An adapter from a Laravel Container to the standardized ContainerInterface
 */
class LaravelContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var LaravelContainerInterface A Laravel Container
     */
    private $container;

    /**
     * @param LaravelContainerInterface $container A Laravel Container
     */
    public function __construct(LaravelContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        if ($this->container->bound($id)) {
            try {
                return $this->container->make($id);
            } catch (\Exception $prev) {
                throw AcclimateContainerException::fromPrevious($id, $prev);
            }
        } else {
            throw AcclimateNotFoundException::fromPrevious($id, null);
        }
    }

    public function has($id)
    {
        return $this->container->bound($id);
    }
}
