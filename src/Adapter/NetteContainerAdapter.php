<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Interop\Container\ContainerInterface as AcclimateContainerInterface;
use Nette\DI\Container as NetteContainerInterface;
use Nette\DI\MissingServiceException as NetteNotFoundException;

/**
 * An adapter from a Nette Container to the standardized ContainerInterface
 */
class NetteContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var NetteContainerInterface Nette Container
     */
    private $container;

    /**
     * @param NetteContainerInterface $container Nette Container
     */
    public function __construct(NetteContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        try {
            return $this->container->getService($id);
        } catch (NetteNotFoundException $prev) {
            throw AcclimateNotFoundException::fromPrevious($id, $prev);
        } catch (\Exception $prev) {
            throw AcclimateContainerException::fromPrevious($id, $prev);
        }
    }

    public function has($id)
    {
        return $this->container->hasService($id);
    }
}
