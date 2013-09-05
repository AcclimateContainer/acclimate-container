<?php

namespace Jeremeamia\Acclimate\Test;

use Jeremeamia\Acclimate\Adapter\PimpleContainerAdapter;
use Jeremeamia\Acclimate\ArrayContainer;
use Jeremeamia\Acclimate\CompositeContainer;
use Pimple;

/**
 * @covers \Jeremeamia\Acclimate\CompositeContainer
 */
class CompositeContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testContainerSupportsContainerInterface()
    {
        $container = new CompositeContainer();
        $container->addContainer(new ArrayContainer(array(
            'array_iterator' => new \ArrayIterator(range(1, 5))
        )));

        $this->assertTrue($container->has('array_iterator'));
        $arrayIterator = $container->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testContainerThrowsExceptionOnNonExistentItem()
    {
        $container = new CompositeContainer();
        $container->addContainer(new ArrayContainer);
        $container->addContainer(new PimpleContainerAdapter(new Pimple));
        $container->addContainer(new ArrayContainer);

        $this->assertFalse($container->has('foo'));

        $this->setExpectedException('Jeremeamia\Acclimate\ServiceNotFoundException');
        $container->get('foo');
    }
}
