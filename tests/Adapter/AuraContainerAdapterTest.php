<?php

namespace Acclimate\Container\Test\Adapter;

use Aura\Di\Config;
use Aura\Di\Forge;
use Acclimate\Container\Adapter\AuraContainerAdapter;
use Aura\Di\Container;

/**
 * @covers \Acclimate\Container\Adapter\AuraContainerAdapter
 */
class AuraContainerAdapterTest extends ContainerAdapterTestBase
{
    protected function createContainer()
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
        $container = $this->createContainer();

        $this->assertTrue($container->has('array_iterator'));
        $arrayIterator = $container->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testThrowsExceptionOnNonExistentItem()
    {
        $container = $this->createContainer();

        $this->assertFalse($container->has('foo'));

        $this->setExpectedException(self::NOT_FOUND_EXCEPTION);
        $container->get('foo');
    }

    public function testAdapterWrapsOtherExceptions()
    {
        $container = $this->createContainer();

        $this->setExpectedException(self::CONTAINER_EXCEPTION);
        $container->get('error');
    }
}
