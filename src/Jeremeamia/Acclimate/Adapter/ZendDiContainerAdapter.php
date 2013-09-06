<?php

namespace Jeremeamia\Acclimate\Adapter;

use Jeremeamia\Acclimate\ContainerInterface as AcclimateContainerInterface;
use Jeremeamia\Acclimate\ServiceNotFoundException as AcclimateException;
use Zend\Di\LocatorInterface;

class ZendDiContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var LocatorInterface
     */
    private $container;

    /**
     * @param LocatorInterface $container
     */
    public function __construct(LocatorInterface $container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        try {
            $result = $this->container->get($name);
            if ($result === null) {
                throw AcclimateException::fromName($name);
            } else {
                return $result;
            }
        } catch (\Exception $prev) {
            throw AcclimateException::fromName($name, $prev);
        }
    }

    public function has($name)
    {
        return ($this->container->get($name) !== null);
    }
}
