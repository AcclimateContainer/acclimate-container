<?php

namespace Jeremeamia\Acclimate\Test\Adapter;

use Jeremeamia\Acclimate\Adapter\PimpleContainerAdapter;
use Pimple;

/**
 * @covers \Jeremeamia\Acclimate\Adapter\PimpleContainerAdapter
 */
class PimpleContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Pimple
     */
    private $container;

    public function setUp()
    {
        $this->container = new Pimple();
        $this->container['array_iterator'] = function() {
            return new \ArrayIterator(range(1, 10));
        };
        $this->container['limit_iterator'] = function($c) {
            return new \LimitIterator($c['array_iterator'], 0, 3);
        };
    }

    public function testAdapterSupportsContainerInterface()
    {
        $adapter = new PimpleContainerAdapter($this->container);

        $this->assertTrue($adapter->has('limit_iterator'));
        $limitIterator = $adapter->get('limit_iterator');
        $this->assertEquals(array(1, 2, 3), iterator_to_array($limitIterator));
    }

    public function testAdapterThrowsExceptionOnNonExistentItem()
    {
        $adapter = new PimpleContainerAdapter($this->container);

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException('Jeremeamia\Acclimate\ServiceNotFoundException');
        $adapter->get('foo');
    }
}
