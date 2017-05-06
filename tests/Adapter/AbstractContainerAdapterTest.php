<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Exception\ContainerException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractContainerAdapterTest extends TestCase
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

        $this->expectException(NotFoundExceptionInterface::class);
        $container->get('foo');
    }

    public function testAdapterWrapsOtherExceptions()
    {
        $container = $this->createContainer();

        try {
            $container->get('error');
        } catch (\Exception $e) {
            $this->assertInstanceOf(ContainerExceptionInterface::class, $e);
            $this->assertEquals(ContainerException::class, get_class($e));
        }
    }

    /**
     * @return ContainerInterface
     */
    abstract protected function createContainer();
}
