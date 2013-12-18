<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Api\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Api\Container\NotFoundException as AcclimateException;
use Zend\Di\LocatorInterface;

/**
 * An adapter from a Zend DIC to the standardized ContainerInterface
 */
class ZendDiContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var LocatorInterface A Zend DIC/ServiceLocator
     */
    private $container;

    /**
     * @param LocatorInterface $container A Zend DIC/ServiceLocator
     */
    public function __construct(LocatorInterface $container)
    {
        $this->container = $container;
    }

    public function get($identifier)
    {
        try {
            $result = $this->container->get($identifier);
            if ($result === null) {
                $prev = null;
            } else {
                return $result;
            }
        } catch (\Exception $prev) {
            // Do nothing, and allow the AcclimateException to be thrown
        }

        throw new AcclimateException("There is no item in the container for \"{$identifier}\".", 0, $prev);
    }

    public function has($identifier)
    {
        return ($this->container->get($identifier) !== null);
    }
}
