<?php

namespace Acclimate\Container\Test\Adapter;

use Aura\Di\Config;
use Aura\Di\Forge;
use Acclimate\Container\Adapter\AuraContainerAdapter;
use Aura\Di\Container;

/**
 * @covers \Acclimate\Container\Adapter\AuraContainerAdapter
 */
class AuraContainerAdapterTest extends ContainerAdapterTestBase
{
    protected function createContainer()
    {
        $container = new Container(new Forge(new Config()));
        $container->set('array_iterator', new \ArrayIterator(range(1, 5)));
        $container->set('error', function() {
            throw new \RuntimeException;
        });

        return new AuraContainerAdapter($container);
    }
}
