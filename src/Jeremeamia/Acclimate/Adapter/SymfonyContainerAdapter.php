<?php

namespace Jeremeamia\Acclimate\Adapter;

use Jeremeamia\Acclimate\ContainerInterface as AcclimateContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException as AcclimateException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class SymfonyContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (ServiceNotFoundException $prev) {
            throw AcclimateException::fromName($name, $prev);
        }
    }

    public function has($name)
    {
        return $this->container->has($name);
    }
}
