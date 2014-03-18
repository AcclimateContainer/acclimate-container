<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\PimpleContainerAdapter;
use Pimple;
use Zend\Di\Exception\RuntimeException;

/**
 * @covers \Acclimate\Container\Adapter\PimpleContainerAdapter
 */
class PimpleContainerAdapterTest extends ContainerAdapterTestBase
{
    protected function createContainer()
    {
        $container = new Pimple();
        $container['array_iterator'] = function() {
            return new \ArrayIterator(range(1, 5));
        };
        $container['error'] = function($c) {
            throw new RuntimeException;
        };

        return new PimpleContainerAdapter($container);
    }
}
