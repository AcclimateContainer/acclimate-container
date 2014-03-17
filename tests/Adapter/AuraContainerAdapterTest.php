<?php

namespace Acclimate\Container\Test\Adapter;

use Aura\Di\Config;
use Aura\Di\Forge;
use Acclimate\Container\Adapter\AuraContainerAdapter;
use Aura\Di\Container;

/**
 * @covers \Acclimate\Container\Adapter\AuraContainerAdapter
 */
class AuraContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    protected function createAdapter()
    {
        $container = new Container(new Forge(new Config()));
        $container->set('array_iterator', new \ArrayIterator(range(1, 5)));
        $container->set('error', function() {
            throw new \RuntimeException;
        });

        return new AuraContainerAdapter($container);
    }

    public function testSupportsContainerInterface()
    {
        $adapter = $this->createAdapter();

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testThrowsExceptionOnNonExistentItem()
    {
        $adapter = $this->createAdapter();

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException(self::NOT_FOUND_EXCEPTION);
        $adapter->get('foo');
    }

    public function testAdapterWrapsOtherExceptions()
    {
        $adapter = $this->createAdapter();

        $this->setExpectedException(self::CONTAINER_EXCEPTION);
        $adapter->get('error');
    }
}
