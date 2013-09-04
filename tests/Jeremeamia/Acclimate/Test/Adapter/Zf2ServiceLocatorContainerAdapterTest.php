<?php

namespace Jeremeamia\Acclimate\Test\Adapter;

use Jeremeamia\Acclimate\Adapter\Zf2ServiceLocatorContainerAdapter;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers \Jeremeamia\Acclimate\Adapter\Zf2ServiceLocatorContainerAdapter
 */
class Zf2ServiceLocatorContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceManager
     */
    private $zf2Container;

    public function setUp()
    {
        $this->zf2Container = new ServiceManager();
        $this->zf2Container->setService('array_iterator', new \ArrayIterator(range(1, 5)));
    }

    public function testCanCreateAdapter()
    {
        $adapter = new Zf2ServiceLocatorContainerAdapter($this->zf2Container);

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));

        $this->assertFalse($adapter->has('foo'));
        $this->assertNull($adapter->get('foo'));
    }
}
