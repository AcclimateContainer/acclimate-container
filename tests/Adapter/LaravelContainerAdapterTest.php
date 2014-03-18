<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\LaravelContainerAdapter;
use Illuminate\Container\Container;

/**
 * @covers \Acclimate\Container\Adapter\LaravelContainerAdapter
 */
class LaravelContainerAdapterTest extends AbstractContainerAdapterTest
{
    protected function createContainer()
    {
        $container = new Container();
        $container->instance('array_iterator', new \ArrayIterator(range(1, 5)));
        $container->bind('error', function () {
            throw new \RuntimeException;
        });

        return new LaravelContainerAdapter($container);
    }
}
