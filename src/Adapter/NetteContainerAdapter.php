<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Api\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Api\Container\NotFoundException as AcclimateException;
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

    public function get($identifier)
    {
        try {
            return $this->container->getService($identifier);
        } catch (MissingServiceException $prev) {
            throw new AcclimateException("There is no item in the container for \"{$identifier}\".", 0, $prev);
        }
    }

    public function has($identifier)
    {
        return $this->container->hasService($identifier);
    }
}
