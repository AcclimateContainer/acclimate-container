<?php

namespace Jeremeamia\Acclimate\Test\Adapter;

use Jeremeamia\Acclimate\Adapter\ZendDiContainerAdapter;
use Zend\Di\ServiceLocator;

/**
 * @covers \Jeremeamia\Acclimate\Adapter\ZendDiContainerAdapter
 */
class ZendDiContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceLocator
     */
    private $container;

    public function setUp()
    {
        $this->container = new ServiceLocator();
        $this->container->set('array_iterator', new \ArrayIterator(range(1, 5)));
    }

    public function testAdapterSupportsContainerInterface()
    {
        $adapter = new ZendDiContainerAdapter($this->container);

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testAdapterThrowsExceptionOnNonExistentItem()
    {
        $adapter = new ZendDiContainerAdapter($this->container);

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException('Jeremeamia\Acclimate\ServiceNotFoundException');
        $adapter->get('foo');
    }
}
