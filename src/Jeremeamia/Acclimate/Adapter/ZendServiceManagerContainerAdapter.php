<?php

namespace Jeremeamia\Acclimate\Adapter;

use Jeremeamia\Acclimate\ContainerInterface as AcclimateContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException as AcclimateException;
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

    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (ServiceNotFoundException $prev) {
            throw AcclimateException::fromName($name, $prev);
        }
    }

    public function has($name)
    {
        return $this->container->has($name);
    }
}
