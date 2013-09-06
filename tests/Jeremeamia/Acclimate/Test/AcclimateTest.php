<?php

namespace Jeremeamia\Acclimate\Test;

use Jeremeamia\Acclimate\Acclimate;
use Jeremeamia\Acclimate\ArrayContainer;

/**
 * @covers \Jeremeamia\Acclimate\Acclimate
 * @covers \Jeremeamia\Acclimate\AdapterNotFoundException
 */
class AcclimateTest extends \PHPUnit_Framework_TestCase
{
    public function testDoesNotAdaptContainerInterface()
    {
        $acclimate = new Acclimate();
        $container1 = new ArrayContainer();
        $container2 = $acclimate->adaptContainer($container1);
        $this->assertSame($container1, $container2);
    }

    public function testAdaptsContainersToContainerInterface()
    {
        $acclimate = new Acclimate();
        $container = $acclimate->adaptContainer($this->getMock('Pimple'));
        $this->assertInstanceOf('Jeremeamia\Acclimate\ContainerInterface', $container);
    }

    public function testCanRegisterOtherAdapters()
    {
        $acclimate = new Acclimate();
        $preCount = count($this->readAttribute($acclimate, 'adapterMap'));
        $acclimate->registerAdapter('foo', 'bar');
        $postCount = count($this->readAttribute($acclimate, 'adapterMap'));
        $this->assertTrue($postCount == $preCount + 1);
    }

    public function testCanAdaptObjectsImplementingArrayAccess()
    {
        $acclimate = new Acclimate();
        $container = $acclimate->adaptContainer(new \ArrayObject);
        $this->assertInstanceOf('Jeremeamia\Acclimate\ContainerInterface', $container);
    }

    public function testThrowsExceptionOnContainersThatCannotBeAdpated()
    {
        $acclimate = new Acclimate();
        $this->setExpectedException('Jeremeamia\Acclimate\AdapterNotFoundException');
        $container = $acclimate->adaptContainer('foo');
    }
}
