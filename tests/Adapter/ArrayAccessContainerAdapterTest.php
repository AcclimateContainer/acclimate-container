<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\ArrayAccessContainerAdapter;
use Acclimate\Container\ArrayContainer;

/**
 * @covers \Acclimate\Container\Adapter\ArrayAccessContainerAdapter
 */
class ArrayAccessContainerAdapterTest extends AbstractContainerAdapterTest
{
    protected function createContainer()
    {
        $container = new ArrayContainer();
        $container['array_iterator'] = new \ArrayIterator(range(1, 5));
        $container['error'] = function() {
            throw new \RuntimeException;
        };

        return new ArrayAccessContainerAdapter($container);
    }

    public function testAdapterWrapsOtherExceptionsDuringGet()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');

        // This should trigger an error
        $container = new ArrayAccessContainerAdapter('not-a-container');
    }
}
