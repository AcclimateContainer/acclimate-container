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
     * @var string Use RETURN_NULL to have the adapter return null for non-existent items
     */
    const RETURN_NULL = 'RETURN_NULL';

    /**
     * @var string Use THROW_EXCEPTION to have the adapter throw an exception for non-existent items
     */
    const THROW_EXCEPTION = 'THROW_EXCEPTION';

    /**
     * @var array Map of adapter classes to base container classes/interfaces
     */
    private static $adapterMap = array(
        'AuraContainerAdapter'                 => 'Aura\Di\ContainerInterface',
        'GuzzleServiceBuilderContainerAdapter' => 'Guzzle\Service\Builder\ServiceBuilderInterface',
        'PimpleContainerAdapter'               => 'Pimple',
        'SymfonyContainerAdapter'              => 'Symfony\Component\DependencyInjection\ContainerInterface',
        'Zf2ServiceLocatorContainerAdapter'    => 'Zend\ServiceManager\ServiceLocatorInterface',
    );

    /**
     * @var string|callback
     */
    private $missingItemHandler;

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

        throw new \UnexpectedValueException("There is no adapter associated with the provided container.");
    }

    /**
     * @param string|callback $missingItemHandler
     */
    public function __construct($missingItemHandler = Acclimate::RETURN_NULL)
    {
        $this->missingItemHandler = $missingItemHandler;
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
            $class = Acclimate::determineAdapterFqcn($container);
            return new $class($container, $this->missingItemHandler);
        }
    }
}
