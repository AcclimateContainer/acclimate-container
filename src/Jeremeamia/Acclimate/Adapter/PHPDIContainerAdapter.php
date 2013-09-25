<?php

namespace Jeremeamia\Acclimate\Adapter;

use DI\Container;
use DI\NotFoundException;
use Jeremeamia\Acclimate\ContainerInterface as AcclimateContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException as AcclimateException;

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

    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (NotFoundException $prev) {
            throw AcclimateException::fromName($name, $prev);
        }
    }

    public function has($name)
    {
        try {
            $this->container->get($name);
            return true;
        } catch (NotFoundException $prev) {
            return false;
        }
    }
}
