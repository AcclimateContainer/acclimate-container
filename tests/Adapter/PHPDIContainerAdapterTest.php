<?php

namespace Acclimate\Container\Test\Adapter;

use DI\Container;
use Acclimate\Container\Adapter\PHPDIContainerAdapter;

/**
 * @covers \Acclimate\Container\Adapter\PHPDIContainerAdapter
 */
class PHPDIContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    private $container;

    public function setUp()
    {
        $this->container = new Container();
        $this->container->set('array_iterator', new \ArrayIterator(range(1, 5)));
    }

    public function testAdapterSupportsContainerInterface()
    {
        $adapter = new PHPDIContainerAdapter($this->container);

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testAdapterThrowsExceptionOnNonExistentItem()
    {
        $adapter = new PHPDIContainerAdapter($this->container);

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException('Acclimate\Api\Container\NotFoundException');
        $adapter->get('foo');
    }
}
