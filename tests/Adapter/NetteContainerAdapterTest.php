<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\NetteContainerAdapter;

/**
 * @covers \Acclimate\Container\Adapter\NetteContainerAdapter
 */
class NetteContainerAdapterTest extends AbstractContainerAdapterTest
{
    protected function createContainer()
    {
        $container = new Fixture\NetteCustomContainer();
        $container->addService('array_iterator', new \ArrayIterator(range(1, 5)));

        return new NetteContainerAdapter($container);
    }
}
