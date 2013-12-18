<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\ArrayContainerAdapter;
use Acclimate\Container\ArrayContainer;

/**
 * @covers \Acclimate\Container\Adapter\ArrayContainerAdapter
 */
class ArrayContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayContainer
     */
    private $container;

    public function setUp()
    {
        $this->container = new ArrayContainer();
        $this->container['array_iterator'] = new \ArrayIterator(range(1, 5));
    }

    public function testAdapterSupportsContainerInterface()
    {
        $adapter = new ArrayContainerAdapter($this->container);

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testAdapterThrowsExceptionOnNonExistentItem()
    {
        $adapter = new ArrayContainerAdapter($this->container);

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException('Acclimate\Api\Container\NotFoundException');
        $adapter->get('foo');
    }

    public function testThrowsExceptionWhenInvalidContainerProvided()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $adapter = new ArrayContainerAdapter('foo'); // Should trigger error
    }
}
