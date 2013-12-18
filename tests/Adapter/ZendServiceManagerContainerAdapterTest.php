<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\ZendServiceManagerContainerAdapter;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers \Acclimate\Container\Adapter\ZendServiceManagerContainerAdapter
 */
class ZendServiceManagerContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceManager
     */
    private $container;

    public function setUp()
    {
        $this->container = new ServiceManager();
        $this->container->setService('array_iterator', new \ArrayIterator(range(1, 5)));
    }

    public function testAdapterSupportsContainerInterface()
    {
        $adapter = new ZendServiceManagerContainerAdapter($this->container);

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testAdapterThrowsExceptionOnNonExistentItem()
    {
        $adapter = new ZendServiceManagerContainerAdapter($this->container);

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException('Acclimate\Api\Container\NotFoundException');
        $adapter->get('foo');
    }
}
