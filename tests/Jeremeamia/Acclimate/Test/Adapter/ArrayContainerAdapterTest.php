<?php

namespace Jeremeamia\Acclimate\Test\Adapter;

use Jeremeamia\Acclimate\Adapter\ArrayContainerAdapter;
use Jeremeamia\Acclimate\ArrayContainer;

/**
 * @covers \Jeremeamia\Acclimate\Adapter\ArrayContainerAdapter
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

    public function testCanCreateAdapter()
    {
        $adapter = new ArrayContainerAdapter($this->arrayContainer);

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));

        $this->assertFalse($adapter->has('foo'));
        $this->assertNull($adapter->get('foo'));
    }
}
