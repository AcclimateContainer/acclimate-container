<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Psr\Container\ContainerInterface;
use Pimple\Container as Pimple;

/**
 * An adapter from a Pimple Container to the standardized ContainerInterface
 */
class PimpleContainerAdapter implements ContainerInterface
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

    public function get($id)
    {
        try {
            return $this->container[$id];
        } catch (\InvalidArgumentException $prev) {
            throw AcclimateNotFoundException::fromPrevious($id, $prev);
        } catch (\Exception $prev) {
            throw AcclimateContainerException::fromPrevious($id, $prev);
        }
    }

    public function has($id)
    {
        return isset($this->container[$id]);
    }
}
