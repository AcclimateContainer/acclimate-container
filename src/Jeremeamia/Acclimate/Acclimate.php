<?php

namespace Jeremeamia\Acclimate;

/**
 * The Acclimate class is used to acclimate a container into your code. It is essentially a factory class for the
 * container adapters in the Acclimate package.
 */
class Acclimate
{
    const ADAPTER_NAMESPACE = 'Jeremeamia\\Acclimate\\Adapter\\';

    /**
     * @var array Map of adapter classes to base container classes/interfaces
     */
    private static $adapterMap = array(
        'ArrayContainerAdapter'                => 'Jeremeamia\Acclimate\ArrayContainer',
        'AuraContainerAdapter'                 => 'Aura\Di\ContainerInterface',
        'GuzzleServiceBuilderContainerAdapter' => 'Guzzle\Service\Builder\ServiceBuilderInterface',
        'PimpleContainerAdapter'               => 'Pimple',
        'SymfonyContainerAdapter'              => 'Symfony\Component\DependencyInjection\ContainerInterface',
        'Zf2ServiceLocatorContainerAdapter'    => 'Zend\ServiceManager\ServiceLocatorInterface',
    );

    /**
     * @param string $adapterFqcn
     *
     * @return string
     * @throws \UnexpectedValueException
     */
    public static function determineContainerFqcn($adapterFqcn)
    {
        $adapterName = substr($adapterFqcn, strlen(self::ADAPTER_NAMESPACE));
        if (isset(self::$adapterMap[$adapterName])) {
            return self::$adapterMap[$adapterName];
        } else {
            throw new \UnexpectedValueException("There is no container associated with the adapter \"{$adapterFqcn}\".");
        }
    }

    /**
     * @param object $container
     *
     * @return string
     * @throws \UnexpectedValueException
     */
    public static function determineAdapterFqcn($container)
    {
        foreach (self::$adapterMap as $adapterName => $containerFqcn) {
            if ($container instanceof $containerFqcn) {
                return self::ADAPTER_NAMESPACE . $adapterName;
            }
        }

        if ($container instanceof \ArrayAccess) {
            return self::ADAPTER_NAMESPACE . 'ArrayContainerAdapter';
        } else {
            throw new \UnexpectedValueException("There is no adapter associated with the provided container.");
        }
    }

    /**
     * @param object $container
     *
     * @return ContainerInterface
     */
    public function getContainerAdapter($container)
    {
        if ($container instanceof ContainerInterface) {
            return $container;
        } else {
            $class = self::determineAdapterFqcn($container);
            return new $class($container);
        }
    }
}
