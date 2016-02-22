<?php

namespace Acclimate\Container\Test;

use Acclimate\Container\ContainerAcclimator;
use Acclimate\Container\ArrayContainer;

/**
 * @covers \Acclimate\Container\ContainerAcclimator
 */
class ContainerAcclimatorTest extends \PHPUnit_Framework_TestCase
{
    public function testDoesNotAdaptContainerInterface()
    {
        $acclimator = new ContainerAcclimator();
        $container1 = new ArrayContainer();
        $container2 = $acclimator->acclimate($container1);
        $this->assertSame($container1, $container2);
    }

    public function testAdaptsContainersToContainerInterface()
    {
        $acclimator = new ContainerAcclimator();
        $container = $acclimator->acclimate($this->getMock('\Pimple\Container'));
        $this->assertInstanceOf('Interop\Container\ContainerInterface', $container);
    }

    public function testCanRegisterOtherAdapters()
    {
        $acclimator = new ContainerAcclimator();
        $preCount = count($this->readAttribute($acclimator, 'adapterMap'));
        $acclimator->registerAdapter('foo', 'bar');
        $postCount = count($this->readAttribute($acclimator, 'adapterMap'));
        $this->assertTrue($postCount == $preCount + 1);
    }

    public function testCanAdaptObjectsImplementingArrayAccess()
    {
        $acclimator = new ContainerAcclimator();
        $container = $acclimator->acclimate(new \ArrayObject);
        $this->assertInstanceOf('Interop\Container\ContainerInterface', $container);
    }

    public function testThrowsExceptionOnContainersThatCannotBeAdpated()
    {
        $acclimator = new ContainerAcclimator();
        $this->setExpectedException('Acclimate\Container\Exception\InvalidAdapterException');
        $container = $acclimator->acclimate('foo');
    }
}
