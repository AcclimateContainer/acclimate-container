<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Exception\ContainerException as Err;

abstract class AbstractContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testSupportsContainerInterface()
    {
        $container = $this->createContainer();

        $this->assertTrue($container->has('array_iterator'));
        $arrayIterator = $container->get('array_iterator');
        $this->assertEquals([1, 2, 3, 4, 5], iterator_to_array($arrayIterator));
    }

    public function testThrowsExceptionOnNonExistentItem()
    {
        $container = $this->createContainer();

        $this->assertFalse($container->has('foo'));

        $this->setExpectedException('Interop\Container\Exception\NotFoundException');
        $container->get('foo');
    }

    public function testAdapterWrapsOtherExceptions()
    {
        $container = $this->createContainer();

        try {
            $container->get('error');
        } catch (\Exception $e) {
            $this->assertInstanceOf('Interop\Container\Exception\ContainerException', $e);
            $this->assertEquals('Acclimate\Container\Exception\ContainerException', get_class($e));
        }
    }

    /**
     * @return \Interop\Container\ContainerInterface
     */
    abstract protected function createContainer();
}
