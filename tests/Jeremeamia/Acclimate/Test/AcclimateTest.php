<?php

namespace Jeremeamia\Acclimate\Test;

use Jeremeamia\Acclimate\Acclimate;
use Jeremeamia\Acclimate\ArrayContainer;

/**
 * @covers \Jeremeamia\Acclimate\Acclimate
 */
class AcclimateTest extends \PHPUnit_Framework_TestCase
{
    public function testCanDetermineContainerFqcnFromAdapterFqcn()
    {
        $adapterMap = $this->readAttribute('Jeremeamia\Acclimate\Acclimate', 'adapterMap');
        foreach ($adapterMap as $adapterName => $containerFqcn) {
            $adapterFqcn = "Jeremeamia\\Acclimate\\Adapter\\{$adapterName}";
            $this->assertEquals($containerFqcn, Acclimate::determineContainerFqcn($adapterFqcn));
        }

        $this->setExpectedException('UnexpectedValueException');
        Acclimate::determineContainerFqcn('foo');
    }

    public function testCanDetermineAdapterFqcnFromContainerObject()
    {
        $pimpleContainer = $this->getMock('Pimple');
        $arrayObject = new \ArrayObject(array('foo' => 'bar'));
        $fooString = 'foo';

        $this->assertEquals(
            'Jeremeamia\Acclimate\Adapter\PimpleContainerAdapter',
            Acclimate::determineAdapterFqcn($pimpleContainer)
        );

        $this->assertEquals(
            'Jeremeamia\Acclimate\Adapter\ArrayContainerAdapter',
            Acclimate::determineAdapterFqcn($arrayObject)
        );

        $this->setExpectedException('UnexpectedValueException');
        Acclimate::determineAdapterFqcn($fooString);
    }

    public function testDoesNotAdaptContainerInterface()
    {
        $acclimate = new Acclimate();
        $container1 = new ArrayContainer();
        $container2 = $acclimate->getContainerAdapter($container1);
        $this->assertSame($container1, $container2);
    }

    public function testAdaptsContainersToContainerInterface()
    {
        $acclimate = new Acclimate();
        $container = $this->getMock('Pimple');
        $container = $acclimate->getContainerAdapter($container);
        $this->assertInstanceOf('Jeremeamia\Acclimate\ContainerInterface', $container);
    }
}
