<?php

namespace Acclimate\Container;

use Acclimate\Api\Acclimator\AcclimatorInterface;
use Acclimate\Api\Acclimator\AdapterMissingException;
use Acclimate\Api\Container\ContainerInterface;

/**
 * This Acclimator class is used to acclimate a container object to the common ContainerInterface. It is essentially a
 * factory class for the container adapters in the Acclimate package.
 */
class ContainerAcclimator implements AcclimatorInterface
{
    /**
     * @var array Default map of container classes to container adapter classes
     */
    private static $predefinedAdapterMap = array(
        'Aura\Di\ContainerInterface' => 'Acclimate\Container\Adapter\AuraContainerAdapter',
        'Guzzle\Service\Builder\ServiceBuilderInterface' => 'Acclimate\Container\Adapter\GuzzleContainerAdapter',
        'Illuminate\Container\Container' => 'Acclimate\Container\Adapter\LaravelContainerAdapter',
        'Nette\DI\Container' => 'Acclimate\Container\Adapter\NetteContainerAdapter',
        'Pimple' => 'Acclimate\Container\Adapter\PimpleContainerAdapter',
        'DI\Container' => 'Acclimate\Container\Adapter\PHPDIContainerAdapter',
        'Symfony\Component\DependencyInjection\ContainerInterface' => 'Acclimate\Container\Adapter\SymfonyContainerAdapter',
        'Zend\Di\LocatorInterface' => 'Acclimate\Container\Adapter\ZendDiContainerAdapter',
        'Zend\ServiceManager\ServiceLocatorInterface' => 'Acclimate\Container\Adapter\ZendServiceManagerContainerAdapter',
        'ArrayAccess' => 'Acclimate\Container\Adapter\ArrayContainerAdapter'
    );

    /**
     * @var array Map of container classes to container adapter classes
     */
    private $adapterMap;

    /**
     * @param array $customAdapterMap Overwrite the predefined adapter map
     */
    public function __construct(array $customAdapterMap = null)
    {
        $this->adapterMap = is_array($customAdapterMap) ? $customAdapterMap : self::$predefinedAdapterMap;
    }

    /**
     * {@inheritdoc}
     * @return ContainerAcclimator
     */
    public function registerAdapter($adapterFqcn, $adapteeFqcn)
    {
        $this->adapterMap[$adapteeFqcn] = $adapterFqcn;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @return ContainerInterface
     */
    public function acclimate($object)
    {
        if ($object instanceof ContainerInterface) {
            return $object;
        } else {
            foreach ($this->adapterMap as $adapteeFqcn => $adapterFqcn) {
                if ($object instanceof $adapteeFqcn) {
                    return new $adapterFqcn($object);
                }
            }
        }

        // If no adapter matches the provided container object, throw an exception
        $type = is_object($object) ? get_class($object) . ' objects' : gettype($object) . ' variables';
        throw new AdapterMissingException("There is no container adapter registered to handle \"{$type}\".");
    }
}
