<?php

namespace Acclimate\Container\Test;

use Acclimate\Container\ContainerAcclimator;
use Acclimate\Container\ArrayContainer;
use PHPUnit\Framework\TestCase;
use Pimple\Container as Pimple;
use Psr\Container\ContainerInterface;

/**
 * @covers \Acclimate\Container\ContainerAcclimator
 */
class ContainerAcclimatorTest extends TestCase
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
        $pimpleContainer = $this->getMockBuilder(Pimple::class)->getMock();
        $container = $acclimator->acclimate($pimpleContainer);
        $this->assertInstanceOf(ContainerInterface::class, $container);
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
        $this->assertInstanceOf(ContainerInterface::class, $container);
    }

    public function testCreateAcclimatedContainerStatically()
    {
        $pimpleContainer = $this->getMockBuilder(Pimple::class)->getMock();
        $container = ContainerAcclimator::acclimateContainer($pimpleContainer);
        $this->assertInstanceOf(ContainerInterface::class, $container);
    }

    public function testThrowsExceptionOnContainersThatCannotBeAdpated()
    {
        $acclimator = new ContainerAcclimator();
        $this->expectException('Acclimate\Container\Exception\InvalidAdapterException');
        $container = $acclimator->acclimate('foo');
    }
}
