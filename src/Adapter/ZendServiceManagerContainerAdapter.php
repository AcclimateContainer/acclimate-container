<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Psr\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException as ZendNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * An adapter from a Zend ServiceManager/ServiceLocator to the standardized ContainerInterface
 */
class ZendServiceManagerContainerAdapter implements ContainerInterface
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

    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch (ZendNotFoundException $prev) {
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
