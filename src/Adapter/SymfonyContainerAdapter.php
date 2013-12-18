<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Api\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Api\Container\NotFoundException as AcclimateException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * An adapter from a Symfony Container to the standardized ContainerInterface
 */
class SymfonyContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var ContainerInterface A Symfony Container
     */
    private $container;

    /**
     * @param ContainerInterface $container A Symfony Container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($identifier)
    {
        try {
            return $this->container->get($identifier);
        } catch (ServiceNotFoundException $prev) {
            throw new AcclimateException("There is no item in the container for \"{$identifier}\".", 0, $prev);
        }
    }

    public function has($identifier)
    {
        return $this->container->has($identifier);
    }
}
