<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Exception\ContainerException as Err;

abstract class ContainerAdapterTestBase extends \PHPUnit_Framework_TestCase
{
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

        $this->setExpectedException('Interop\Container\Exception\NotFoundException', '', Err::NOT_FOUND_ERROR);
        $container->get('foo');
    }

    public function testAdapterWrapsOtherExceptions()
    {
        $container = $this->createContainer();

        $this->setExpectedException('Interop\Container\Exception\ContainerException', '', Err::GENERIC_ERROR);
        $container->get('error');
    }

    /**
     * @return \Interop\Container\ContainerInterface
     */
    abstract protected function createContainer();
}
