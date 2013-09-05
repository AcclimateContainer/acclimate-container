<?php

namespace Jeremeamia\Acclimate\Test\Decorator;

use Jeremeamia\Acclimate\ArrayContainer;
use Jeremeamia\Acclimate\Decorator\AbstractContainerDecorator;

class ContainerDecorator extends AbstractContainerDecorator {}

/**
 * @covers \Jeremeamia\Acclimate\Decorator\AbstractContainerDecorator
 */
class AbstractContainerDecoratorTest extends \PHPUnit_Framework_TestCase
{
    public function testDecoratorImplementsContainerInterface()
    {
        $container = new ContainerDecorator(new ArrayContainer);
        $this->assertFalse($container->has('foo'));
        $this->setExpectedException('Jeremeamia\Acclimate\ServiceNotFoundException');
        $container->get('foo');
    }
}
