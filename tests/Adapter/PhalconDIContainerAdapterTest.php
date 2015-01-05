<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\PhalconDIContainerAdapter;
use Phalcon\DI as PhalconDI;

/**
 * @requires extension phalcon
 */
class PhalconDIContainerAdapterTest extends AbstractContainerAdapterTest {
    
    protected function createContainer()
    {
        $container = new PhalconDI();
        $container->setShared('array_iterator', new \ArrayIterator(range(1, 5)));
        $container->set('error', function() {
            throw new \RuntimeException;
        });

        return new PhalconDIContainerAdapter($container);
    }

}
