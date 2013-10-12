<?php

namespace Jeremeamia\Acclimate\Adapter;

use Jeremeamia\Acclimate\ContainerInterface as AcclimateContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException as AcclimateException;
use Nette\DI\Container;
use Nette\DI\MissingServiceException;

/**
 * An adapter from a Nette Container to the standardized ContainerInterface
 */
class NetteContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var Container Nette Container
     */
    private $container;

    /**
     * @param Container $container Nette Container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        try {
            return $this->container->getService($name);
        } catch (MissingServiceException $prev) {
            throw AcclimateException::fromName($name, $prev);
        }
    }

    public function has($name)
    {
        return $this->container->hasService($name);
    }
}
