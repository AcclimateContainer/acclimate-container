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
        $container['error'] = function () {
            throw new \RuntimeException;
        };

        return new ArrayAccessContainerAdapter($container);
    }

    public function testAdapterWrapsOtherExceptionsDuringGet()
    {
        if (version_compare(PHP_VERSION, '7.0.0') < 0) {
            $this->doConstructionTestInPhp5();
        } else {
            $this->doConstructionTestInPhp7();
        }
    }

    private function doConstructionTestInPhp5()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');

        // This should trigger an error
        $container = new ArrayAccessContainerAdapter('not-a-container');
    }

    private function doConstructionTestInPhp7()
    {
        $typeErrorOccurred = false;

        try {
            $container = new ArrayAccessContainerAdapter('not-a-container');
        } catch (\TypeError $typeError) {
            $typeErrorOccurred = true;
        }

        $this->assertTrue($typeErrorOccurred, 'TypeError should have occurred');
    }
}
