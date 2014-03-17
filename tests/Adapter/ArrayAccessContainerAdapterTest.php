<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\ArrayAccessContainerAdapter;
use Acclimate\Container\ArrayContainer;

/**
 * @covers \Acclimate\Container\Adapter\ArrayAccessContainerAdapter
 */
class ArrayAccessContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    protected function createAdapter()
    {
        $container = new ArrayContainer();
        $container['array_iterator'] = new \ArrayIterator(range(1, 5));
        $container['error'] = function() {
            throw new \RuntimeException;
        };

        return new ArrayAccessContainerAdapter($container);
    }

    public function testSupportsContainerInterface()
    {
        $adapter = $this->createAdapter();

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testThrowsExceptionOnNonExistentItem()
    {
        $adapter = $this->createAdapter();

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException(self::NOT_FOUND_EXCEPTION);
        $adapter->get('foo');
    }

    public function testAdapterWrapsOtherExceptions()
    {
        $adapter = $this->createAdapter();

        $this->setExpectedException(self::CONTAINER_EXCEPTION);
        $adapter->get('error');
    }

    public function testAdapterWrapsOtherExceptionsDuringGet()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');

        // This should trigger an error
        $adapter = new ArrayAccessContainerAdapter('not-a-container');
    }
}
