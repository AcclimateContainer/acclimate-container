<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Interop\Container\ContainerInterface as AcclimateContainerInterface;
use League\Container\ContainerInterface;
use League\Container\Exception\ReflectionException;

/**
 * An adapter from a League Container to the standardized ContainerInterface
 */
class LeagueContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var ContainerInterface A League Container
     */
    private $container;

    /**
     * @param ContainerInterface $container A League Container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch (\ReflectionException $prev) {
            throw AcclimateNotFoundException::fromPrevious($id, $prev);
        } catch (\Exception $prev) {
            throw AcclimateContainerException::fromPrevious($id, $prev);
        }
    }

    public function has($id)
    {
        try {
            $this->container->get($id);

            return true;
        } catch (ReflectionException $e) {
            return false;
        }
    }
}
