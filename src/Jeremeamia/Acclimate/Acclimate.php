<?php

namespace Jeremeamia\Acclimate;

use Jeremeamia\Acclimate\Adapter\ArrayContainerAdapter;

/**
 * The Acclimate class is used to acclimate a container into your code. It is essentially a factory class for the
 * container adapters in the Acclimate package.
 */
class Acclimate
{
    /**
     * @var array Map of container classes to container adapter class
     */
    private $adapterMap = array(
        'Aura\Di\ContainerInterface' => 'Jeremeamia\Acclimate\Adapter\AuraContainerAdapter',
        'Guzzle\Service\Builder\ServiceBuilderInterface' => 'Jeremeamia\Acclimate\Adapter\GuzzleContainerAdapter',
        'Illuminate\Container\Container' => 'Jeremeamia\Acclimate\Adapter\LaravelContainerAdapter',
        'Pimple' => 'Jeremeamia\Acclimate\Adapter\PimpleContainerAdapter',
        'Symfony\Component\DependencyInjection\ContainerInterface' => 'Jeremeamia\Acclimate\Adapter\SymfonyContainerAdapter',
        'Zend\Di\LocatorInterface' => 'Jeremeamia\Acclimate\Adapter\ZendDiContainerAdapter',
        'Zend\ServiceManager\ServiceLocatorInterface' => 'Jeremeamia\Acclimate\Adapter\ZendServiceManagerContainerAdapter',
    );

    /**
     * @param array $adapterMap Additional adapters to register
     */
    public function __construct(array $adapterMap = array())
    {
        $this->adapterMap = $adapterMap + $this->adapterMap;
    }

    /**
     * Registers a custom adapter class for a container using their FQCNs
     *
     * @param string $adapterFqcn   The fully qualified class name of the container adapter
     * @param string $containerFqcn The fully qualified class name of the container
     *
     * @return $this
     */
    public function registerAdapter($adapterFqcn, $containerFqcn)
    {
        $this->adapterMap[$containerFqcn] = $adapterFqcn;

        return $this;
    }

    /**
     * Adapts a container object by wrapping it with an adapter class that implements ContainerInterface
     *
     * @param mixed $container A third-party service container object
     *
     * @return ContainerInterface
     * @throws AdapterNotFoundException if an adapter for the provided container isn't found
     */
    public function adaptContainer($container)
    {
        if ($container instanceof ContainerInterface) {
            return $container;
        } else {
            foreach ($this->adapterMap as $containerFqcn => $adapterFqcn) {
                if ($container instanceof $containerFqcn) {
                    return new $adapterFqcn($container);
                }
            }
            if ($container instanceof \ArrayAccess) {
                return new ArrayContainerAdapter($container);
            } else {
                throw AdapterNotFoundException::fromContainer($container);
            }

        }
    }
}
