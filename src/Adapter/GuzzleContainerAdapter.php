<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Guzzle\Service\Builder\ServiceBuilderInterface as GuzzleContainerInterface;
use Guzzle\Service\Exception\ServiceNotFoundException as GuzzleNotFoundException;
use Interop\Container\ContainerInterface as AcclimateContainerInterface;

/**
 * @deprecated in v1.1
 * An adapter from a Guzzle ServiceBuilder to the standardized ContainerInterface
 */
class GuzzleContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var GuzzleContainerInterface A Guzzle ServiceBuilder
     */
    private $container;

    /**
     * @param GuzzleContainerInterface $container A Guzzle ServiceBuilder
     */
    public function __construct(GuzzleContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch (GuzzleNotFoundException $prev) {
            throw AcclimateNotFoundException::fromPrevious($id, $prev);
        } catch (\Exception $prev) {
            throw AcclimateContainerException::fromPrevious($id, $prev);
        }
    }

    public function has($id)
    {
        return isset($this->container[$id]);
    }
}
