<?php

namespace Acclimate\Container;

use Acclimate\Container\Exception\InvalidAdapterException;
use Psr\Container\ContainerInterface;

/**
 * This class is used to "acclimate", or adapt, a container object (e.g., DIC, SL) to a common ContainerInterface. In
 * terms of design patterns, it's essentially a `factory` for `adapter`s
 */
class ContainerAcclimator
{
    /**
     * @var array Map of container classes to container adapter classes
     */
    private $adapterMap;

    /**
     * Create an adaptor statically for a particular container.
     *
     * @param mixed $container A third-party object to be acclimated
     * @param array|null $customAdapterMap An optional adapter map to pass to the acclimator
     * @return ContainerInterface
     */
    public static function acclimateContainer($container, array $customAdapterMap = null)
    {
        $acclimator = new self($customAdapterMap);

        return $acclimator->acclimate($container);
    }

    /**
     * @param array $customAdapterMap Overwrite the predefined adapter map
     */
    public function __construct(array $customAdapterMap = null)
    {
        $this->adapterMap = is_array($customAdapterMap) ? $customAdapterMap : include 'Adapter/map.php';
    }

    /**
     * Registers a custom adapter for a class by mapping the fully qualified class name (FQCN) of one to the other
     *
     * @param string $adapterFqcn The FQCN of the adapter class
     * @param string $adapteeFqcn The FQCN of the class being adapted
     *
     * @return ContainerAcclimator
     */
    public function registerAdapter($adapterFqcn, $adapteeFqcn)
    {
        $this->adapterMap[$adapteeFqcn] = $adapterFqcn;

        return $this;
    }

    /**
     * Adapts an object by wrapping it with a registered adapter class that implements an Acclimate interface
     *
     * @param mixed $adaptee A third-party object to be acclimated
     *
     * @return ContainerInterface
     * @throws InvalidAdapterException if there is no adapter found for the provided object
     */
    public function acclimate($adaptee)
    {
        if ($adaptee instanceof ContainerInterface) {
            // If the adaptee already implements the ContainerInterface, just return it
            return $adaptee;
        } else {
            // Otherwise, check the adapter map to see if there is an appropriate adapter registered
            foreach ($this->adapterMap as $adapteeFqcn => $adapterFqcn) {
                if ($adaptee instanceof $adapteeFqcn) {
                    return new $adapterFqcn($adaptee);
                }
            }
        }

        // If no adapter matches the provided container object, throw an exception
        throw InvalidAdapterException::fromAdaptee($adaptee);
    }
}
