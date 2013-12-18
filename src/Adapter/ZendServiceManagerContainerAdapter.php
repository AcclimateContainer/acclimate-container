<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Api\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Api\Container\NotFoundException as AcclimateException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * An adapter from a Zend ServiceManager/ServiceLocator to the standardized ContainerInterface
 */
class ZendServiceManagerContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var ServiceLocatorInterface A Zend ServiceManager/ServiceLocator
     */
    private $container;

    /**
     * @param ServiceLocatorInterface $container A Zend ServiceManager/ServiceLocator
     */
    public function __construct(ServiceLocatorInterface $container)
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
