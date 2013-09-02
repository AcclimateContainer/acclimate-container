<?php

namespace Jeremeamia\Acclimate;

class Acclimate
{
    const RETURN_NULL = 'RETURN_NULL';
    const THROW_EXCEPTION = 'THROW_EXCEPTION';

    /**
     * @var array
     */
    private static $adapterMap = array(
        'Pimple'                              => 'PimpleContainerAdapter',
        'Jeremeamia\Acclimate\ArrayContainer' => 'ArrayContainerAdapter',
    );

    /**
     * @var string|callback
     */
    private $missingItemHandler;

    /**
     * @param string|callback $missingItemHandler
     */
    public function __construct($missingItemHandler = Acclimate::RETURN_NULL)
    {
        $this->missingItemHandler = $missingItemHandler;
    }

    /**
     * @param mixed $container
     *
     * @return ContainerInterface
     * @throws \RuntimeException
     */
    public function getContainerAdapter($container)
    {
        if ($class = $this->determineAdapterClass($container)) {
            return new $class($container, $this->missingItemHandler);
        } else {
            throw new \RuntimeException('The container did not have an associated adapter and could be acclimated.');
        }
    }

    /**
     * @param mixed $container
     *
     * @return null|string
     */
    private function determineAdapterClass(&$container)
    {
        $namespace = __NAMESPACE__ . '\\Adapter\\';

        if (is_object($container)) {
            $containerClass = get_class($container);
            if (isset(self::$adapterMap[$containerClass])) {
                return $namespace . self::$adapterMap[$containerClass];
            } elseif ($container instanceof \Traversable) {
                $container = iterator_to_array($container, true);
            }
        }

        if (is_array($container)) {
            $container = new ArrayContainer($container);
            return "{$namespace}ArrayContainerAdapter";
        }

        return null;
    }
}
