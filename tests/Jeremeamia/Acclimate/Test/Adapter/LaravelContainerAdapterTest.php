<?php

namespace Jeremeamia\Acclimate\Test\Adapter;

use Jeremeamia\Acclimate\Adapter\LaravelContainerAdapter;
use Illuminate\Container\Container;

/**
 * @covers \Jeremeamia\Acclimate\Adapter\LaravelContainerAdapter
 */
class LaravelContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    private $laravelContainer;

    public function setUp()
    {
        $this->laravelContainer = new Container();
        $this->laravelContainer->instance('array_iterator', new \ArrayIterator(range(1, 5)));
    }

    public function testAdapterSupportsContainerInterface()
    {
        $adapter = new LaravelContainerAdapter($this->laravelContainer);

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testAdapterThrowsExceptionOnNonExistentItem()
    {
        $adapter = new LaravelContainerAdapter($this->laravelContainer);

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException('Jeremeamia\Acclimate\ServiceNotFoundException');
        $adapter->get('foo');
    }
}
