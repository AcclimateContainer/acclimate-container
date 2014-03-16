<?php

namespace Acclimate\Container\Adapter;

use Aura\Di\ContainerInterface as AuraContainerInterface;
use Aura\Di\Exception\ServiceNotFound as AuraNotFoundException;
use Interop\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;

/**
 * An adapter from an Aura DIC to the standardized ContainerInterface
 */
class AuraContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var AuraContainerInterface An Aura DIC
     */
    private $container;

    /**
     * @param AuraContainerInterface $container An Aura DIC
     */
    public function __construct(AuraContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch (AuraNotFoundException $prev) {
            throw AcclimateNotFoundException::fromPrevious($id, $prev);
        } catch (\Exception $prev) {
            throw AcclimateContainerException::fromPrevious($id, $prev);
        }
    }

    public function has($id)
    {
        return $this->container->has($id);
    }
}
