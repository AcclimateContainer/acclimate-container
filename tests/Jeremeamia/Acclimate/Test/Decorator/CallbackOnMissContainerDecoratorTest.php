<?php

namespace Jeremeamia\Acclimate\Test\Decorator;

use Jeremeamia\Acclimate\Decorator\CallbackOnMissContainerDecorator;
use Jeremeamia\Acclimate\ArrayContainer;

/**
 * @covers \Jeremeamia\Acclimate\Decorator\CallbackOnMissContainerDecorator
 */
class CallbackOnMissContainerDecoratorTest extends \PHPUnit_Framework_TestCase
{
    public function testDecoratorExecutesCallbackForMissingItems()
    {
        $container = new CallbackOnMissContainerDecorator(new ArrayContainer, function ($name) {
            return 'CALLBACK!';
        });
        $this->assertFalse($container->has('foo'));
        $this->assertEquals('CALLBACK!', $container->get('foo'));
    }

    public function testDecoratorThrowsExceptionIfCallbackIsInvalid()
    {
        $this->setExpectedException('InvalidArgumentException');
        $container = new CallbackOnMissContainerDecorator(new ArrayContainer, 'foo');
    }
}
