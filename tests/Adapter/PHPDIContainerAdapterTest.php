<?php

namespace Acclimate\Container\Test\Adapter;

use DI\Container;
use Acclimate\Container\Adapter\PHPDIContainerAdapter;

/**
 * @covers \Acclimate\Container\Adapter\PHPDIContainerAdapter
 */
class PHPDIContainerAdapterTest extends ContainerAdapterTestBase
{
    protected function createContainer()
    {
        $container = new Container();
        $container->set('array_iterator', new \ArrayIterator(range(1, 5)));
        $container->set('error', function () {
            throw new \RuntimeException;
        });

        return new PHPDIContainerAdapter($container);
    }
}
