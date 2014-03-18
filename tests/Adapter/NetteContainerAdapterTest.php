<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\NetteContainerAdapter;
use Nette\DI\Container;

/**
 * @covers \Acclimate\Container\Adapter\NetteContainerAdapter
 */
class NetteContainerAdapterTest extends AbstractContainerAdapterTest
{
    protected function createContainer()
    {
        $container = new Container();
        $container->array_iterator = new \ArrayIterator(range(1, 5));
        $container->error = function () {
            throw new \RuntimeException;
        };

        return new NetteContainerAdapter($container);
    }
}
