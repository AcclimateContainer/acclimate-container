<?php

namespace Acclimate\Container\Test\Decorator;

use Acclimate\Container\Decorator\NullOnMissContainer;
use Acclimate\Container\ArrayContainer;

/**
 * @covers \Acclimate\Container\Decorator\NullOnMissContainer
 */
class NullOnMissContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testDecoratorReturnsNullForMissingItems()
    {
        $container = new NullOnMissContainer(new ArrayContainer);
        $this->assertFalse($container->has('foo'));
        $this->assertNull($container->get('foo'));
    }
}
