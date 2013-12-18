<?php

namespace Acclimate\Container\Adapter;

use DI\Container;
use DI\NotFoundException;
use Acclimate\Api\Container\ContainerInterface as AcclimateContainerInterface;
use Acclimate\Api\Container\NotFoundException as AcclimateException;

/**
 * An adapter from a PHP-DI Container to the standardized ContainerInterface
 */
class PHPDIContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var Container A PHP-DI Container
     */
    private $container;

    /**
     * @param Container $container A PHP-DI Container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get($identifier)
    {
        try {
            return $this->container->get($identifier);
        } catch (NotFoundException $prev) {
            throw new AcclimateException("There is no item in the container for \"{$identifier}\".", 0, $prev);
        }
    }

    public function has($identifier)
    {
        try {
            $this->container->get($identifier);
            return true;
        } catch (NotFoundException $prev) {
            return false;
        }
    }
}
