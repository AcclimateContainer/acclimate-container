<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\NjasmContainerAdapter;
use Njasm\Container\Container;

/**
 * @covers \Acclimate\Container\Adapter\NjasmContainerAdapter
 */
class NjasmContainerAdapterTest extends AbstractContainerAdapterTest
{
    protected function createContainer()
    {
        $container = new Container();
        $container->set('array_iterator', new \ArrayIterator(range(1, 5)));
        $container->set('error', function() {
            throw new \RuntimeException;
        });

        return new NjasmContainerAdapter($container);
    }
}
