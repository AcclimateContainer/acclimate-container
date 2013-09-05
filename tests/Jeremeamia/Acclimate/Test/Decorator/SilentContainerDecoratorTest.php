<?php

namespace Jeremeamia\Acclimate\Test\Decorator;

use Jeremeamia\Acclimate\Decorator\SilentContainerDecorator;
use Jeremeamia\Acclimate\ArrayContainer;

/**
 * @covers \Jeremeamia\Acclimate\Decorator\SilentContainerDecorator
 */
class SilentContainerDecoratorTest extends \PHPUnit_Framework_TestCase
{
    public function testDecoratorReturnsNullForMissingItems()
    {
        $container = new SilentContainerDecorator(new ArrayContainer);
        $this->assertFalse($container->has('foo'));
        $this->assertNull($container->get('foo'));
    }
}
