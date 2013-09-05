<?php

namespace Jeremeamia\Acclimate\Test\Adapter;

use Aura\Di\Config;
use Aura\Di\Forge;
use Jeremeamia\Acclimate\Adapter\AuraContainerAdapter;
use Aura\Di\Container;

/**
 * @covers \Jeremeamia\Acclimate\Adapter\AuraContainerAdapter
 */
class AuraContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    private $auraContainer;

    public function setUp()
    {
        $this->auraContainer = new Container(new Forge(new Config()));
        $this->auraContainer->set('array_iterator', new \ArrayIterator(range(1, 5)));
    }

    public function testAdapterSupportsContainerInterface()
    {
        $adapter = new AuraContainerAdapter($this->auraContainer);

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testAdapterThrowsExceptionOnNonExistentItem()
    {
        $adapter = new AuraContainerAdapter($this->auraContainer);

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException('Jeremeamia\Acclimate\ServiceNotFoundException');
        $adapter->get('foo');
    }
}
