<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\ZendServiceManagerContainerAdapter;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers \Acclimate\Container\Adapter\ZendServiceManagerContainerAdapter
 */
class ZendServiceManagerContainerAdapterTest extends AbstractContainerAdapterTest
{
    protected function createContainer()
    {
        $container = new ServiceManager();
        $container->setService('array_iterator', new \ArrayIterator(range(1, 5)));
        $container->setFactory('error', function () {
            throw new \RuntimeException;
        });

        return new ZendServiceManagerContainerAdapter($container);
    }
}
