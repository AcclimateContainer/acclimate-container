<?php

namespace Acclimate\Container\Test\Decorator;

use Acclimate\Container\Decorator\NullOnMissContainer;
use Acclimate\Container\ArrayContainer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Acclimate\Container\Decorator\NullOnMissContainer
 */
class NullOnMissContainerDecoratorTest extends TestCase
{
    public function testDecoratorReturnsNullForMissingItems()
    {
        $container = new NullOnMissContainer(new ArrayContainer);
        $this->assertFalse($container->has('foo'));
        $this->assertNull($container->get('foo'));
    }
}
