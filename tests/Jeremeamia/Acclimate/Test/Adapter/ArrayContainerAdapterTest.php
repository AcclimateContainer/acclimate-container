<?php

namespace Jeremeamia\Acclimate\Test\Adapter;

use Jeremeamia\Acclimate\Adapter\ArrayContainerAdapter;
use Jeremeamia\Acclimate\ArrayContainer;

/**
 * @covers \Jeremeamia\Acclimate\Adapter\ArrayContainerAdapter
 * @covers \Jeremeamia\Acclimate\Adapter\AbstractContainerAdapter
 */
class ArrayContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayContainer
     */
    private $arrayContainer;

    public function setUp()
    {
        $this->arrayContainer = new ArrayContainer();
        $this->arrayContainer['array_iterator'] = new \ArrayIterator(range(1, 5));
    }

    public function testAdapterSupportsContainerInterface()
    {
        $adapter = new ArrayContainerAdapter($this->arrayContainer);

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testAdapterThrowsExceptionOnNonExistentItem()
    {
        $adapter = new ArrayContainerAdapter($this->arrayContainer);

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException('Jeremeamia\Acclimate\ServiceNotFoundException');
        $adapter->get('foo');
    }

    public function testThrowsExceptionWhenInvalidContainerProvided()
    {
        $this->setExpectedException('InvalidArgumentException');
        $adapter = new ArrayContainerAdapter(new \SplQueue);
    }
}
