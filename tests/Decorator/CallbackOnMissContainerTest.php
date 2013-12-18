<?php

namespace Acclimate\Container\Test\Decorator;

use Acclimate\Container\Decorator\CallbackOnMissContainer;
use Acclimate\Container\ArrayContainer;

/**
 * @covers \Acclimate\Container\Decorator\CallbackOnMissContainer
 */
class CallbackOnMissContainerTest extends \PHPUnit_Framework_TestCase
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
        $this->setExpectedException('InvalidArgumentException');
        $container = new CallbackOnMissContainer(new ArrayContainer, 'foo');
    }
}
