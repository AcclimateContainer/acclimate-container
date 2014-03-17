<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\PimpleContainerAdapter;
use Pimple;
use Zend\Di\Exception\RuntimeException;

/**
 * @covers \Acclimate\Container\Adapter\PimpleContainerAdapter
 */
class PimpleContainerAdapterTest extends ContainerAdapterTestBase
{
    protected function createContainer()
    {
        $container = new Pimple();
        $container['array_iterator'] = function() {
            return new \ArrayIterator(range(1, 10));
        };
        $container['limit_iterator'] = function($c) {
            return new \LimitIterator($c['array_iterator'], 0, 3);
        };
        $container['error'] = function($c) {
            throw new RuntimeException;
        };

        return new PimpleContainerAdapter($container);
    }

    public function testSupportsContainerInterface()
    {
        $container = $this->createContainer();

        $this->assertTrue($container->has('limit_iterator'));
        $limitIterator = $container->get('limit_iterator');
        $this->assertEquals(array(1, 2, 3), iterator_to_array($limitIterator));
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
