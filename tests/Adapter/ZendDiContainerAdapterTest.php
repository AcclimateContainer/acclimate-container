<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\ZendDiContainerAdapter;
use Zend\Di\Exception\RuntimeException;
use Zend\Di\ServiceLocator;

/**
 * @covers \Acclimate\Container\Adapter\ZendDiContainerAdapter
 */
class ZendDiContainerAdapterTest extends ContainerAdapterTestBase
{
    protected function createContainer()
    {
        $container = new ServiceLocator();
        $container->set('array_iterator', new \ArrayIterator(range(1, 5)));
        $container->set('error', function () {
            throw new RuntimeException;
        });

        return new ZendDiContainerAdapter($container);
    }
}
