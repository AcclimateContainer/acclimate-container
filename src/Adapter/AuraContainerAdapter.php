<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Aura\Di\ContainerInterface as AuraContainerInterface;
use Aura\Di\Exception\ServiceNotFound as AuraNotFoundException;
use Psr\Container\ContainerInterface as AcclimateContainerInterface;

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

    public function has($id): bool
    {
        return $this->container->has($id);
    }
}
