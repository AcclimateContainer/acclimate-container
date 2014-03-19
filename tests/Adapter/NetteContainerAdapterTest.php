<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\NetteContainerAdapter;
use Nette\DI\Container as NetteContainer;

/**
 * Special container with exception throwing service
 */
class Container extends NetteContainer
{
    public function createServiceError()
    {
        throw new \RuntimeException();
    }
}

/**
 * @covers \Acclimate\Container\Adapter\NetteContainerAdapter
 */
class NetteContainerAdapterTest extends AbstractContainerAdapterTest
{
    protected function createContainer()
    {
        $container = new Container();
        $container->addService('array_iterator', new \ArrayIterator(range(1, 5)));

        return new NetteContainerAdapter($container);
    }
}
