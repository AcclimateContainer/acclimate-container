<?php

namespace Acclimate\Container\Adapter;

use Guzzle\Service\Builder\ServiceBuilderInterface;
use Guzzle\Service\Exception\ServiceNotFoundException;
use Acclimate\Api\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Api\Container\NotFoundException as AcclimateException;

/**
 * An adapter from a Guzzle ServiceBuilder to the standardized ContainerInterface
 */
class GuzzleContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var ServiceBuilderInterface A Guzzle ServiceBuilder
     */
    private $container;

    /**
     * @param ServiceBuilderInterface $container A Guzzle ServiceBuilder
     */
    public function __construct(ServiceBuilderInterface $container)
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
        return isset($this->container[$identifier]);
    }
}
