<?php

namespace Jeremeamia\Acclimate\Test\Decorator;

use Jeremeamia\Acclimate\Decorator\NullOnMissContainerDecorator;
use Jeremeamia\Acclimate\ArrayContainer;

/**
 * @covers \Jeremeamia\Acclimate\Decorator\NullOnMissContainerDecorator
 */
class NullOnMissContainerDecoratorTest extends \PHPUnit_Framework_TestCase
{
    public function testDecoratorReturnsNullForMissingItems()
    {
        $container = new NullOnMissContainerDecorator(new ArrayContainer);
        $this->assertFalse($container->has('foo'));
        $this->assertNull($container->get('foo'));
    }
}
