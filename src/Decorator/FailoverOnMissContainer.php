<?php

namespace Acclimate\Container\Decorator;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\NotFoundException;

/**
 * A container decorator that delegates to a designated failover container if the decorated container does not contain
 * the requested entry
 */
class FailoverOnMissContainer extends AbstractContainerDecorator
{
    /**
     * @var ContainerInterface
     */
    private $failoverContainer;

    /**
     * @param ContainerInterface $container         The container being decorated
     * @param ContainerInterface $failoverContainer The container to act as a failover
     */
    public function __construct(ContainerInterface $container, ContainerInterface $failoverContainer)
    {
        parent::__construct($container);
        $this->failoverContainer = $failoverContainer;
    }

    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch (NotFoundException $e) {
            return $this->failoverContainer->get($id);
        }
    }
}
