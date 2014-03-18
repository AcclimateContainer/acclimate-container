<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\ZendServiceManagerContainerAdapter;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers \Acclimate\Container\Adapter\ZendServiceManagerContainerAdapter
 */
class ZendServiceManagerContainerAdapterTest extends ContainerAdapterTestBase
{
    protected function createContainer()
    {
        $container = new ServiceManager();
        $container->setService('array_iterator', new \ArrayIterator(range(1, 5)));
        // @TODO The following line is wrong, but I need to figure out how to inject an error case
        $container->addDelegator('error', function () {
            throw new \RuntimeException;
        });

        return new ZendServiceManagerContainerAdapter($container);
    }
}
