<?php

namespace Acclimate\Container\Test\Decorator;

use Acclimate\Container\Decorator\CallbackOnMissContainer;
use Acclimate\Container\ArrayContainer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Acclimate\Container\Decorator\CallbackOnMissContainer
 */
class CallbackOnMissContainerTest extends TestCase
{
    public function testDecoratorExecutesCallbackForMissingItems()
    {
        $container = new CallbackOnMissContainer(new ArrayContainer, function ($name) {
            return 'CALLBACK!';
        });
        $this->assertFalse($container->has('foo'));
        $this->assertEquals('CALLBACK!', $container->get('foo'));
    }

    public function testDecoratorThrowsExceptionIfCallbackIsInvalid()
    {
        $this->expectException('InvalidArgumentException');
        $container = new CallbackOnMissContainer(new ArrayContainer, 'foo');
    }
}
