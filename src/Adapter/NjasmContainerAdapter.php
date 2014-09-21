<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Njasm\Container\ServicesProviderInterface as NjasmContainerInterface;
use Njasm\Container\Exception\ContainerException as NjasmNotFoundException;
use Interop\Container\ContainerInterface as AcclimateContainerInterface;

/**
 * An adapter from an Njasm DIC to the standardized ContainerInterface
 */
class NjasmContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var NjasmContainerInterface An Njasm DIC
     */
    private $container;

    /**
     * @param NjasmContainerInterface $container An Njasm DIC
     */
    public function __construct(NjasmContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch (NjasmNotFoundException $prev) {
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
