<?php

namespace Acclimate\Container\Test;

use Acclimate\Container\Adapter\PimpleContainerAdapter;
use Acclimate\Container\ArrayContainer;
use Acclimate\Container\CompositeContainer;
use Pimple;

/**
 * @covers \Acclimate\Container\CompositeContainer
 */
class CompositeContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testSupportsContainerInterface()
    {
        $container = new CompositeContainer(array(
            new ArrayContainer(['array_iterator' => new \ArrayIterator(range(1, 5))])
        ));

        $this->assertTrue($container->has('array_iterator'));
        $arrayIterator = $container->get('array_iterator');
        $this->assertEquals([1, 2, 3, 4, 5], iterator_to_array($arrayIterator));
    }

    public function testThrowsExceptionOnNonExistentItem()
    {
        $container = new CompositeContainer();
        $container->addContainer(new ArrayContainer);
        $container->addContainer(new PimpleContainerAdapter(new Pimple));
        $container->addContainer(new ArrayContainer);

        $this->assertFalse($container->has('foo'));

        $this->setExpectedException('Interop\Container\Exception\NotFoundException');
        $container->get('foo');
    }
}
