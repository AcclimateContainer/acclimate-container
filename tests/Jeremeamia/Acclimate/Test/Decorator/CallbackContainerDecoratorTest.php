<?php

namespace Jeremeamia\Acclimate\Test\Decorator;

use Jeremeamia\Acclimate\Decorator\CallbackContainerDecorator;
use Jeremeamia\Acclimate\ArrayContainer;

/**
 * @covers \Jeremeamia\Acclimate\Decorator\CallbackContainerDecorator
 */
class CallbackContainerDecoratorTest extends \PHPUnit_Framework_TestCase
{
    public function testDecoratorExecutesCallbackForMissingItems()
    {
        $container = new CallbackContainerDecorator(new ArrayContainer, function ($name) {
            return 'CALLBACK!';
        });
        $this->assertFalse($container->has('foo'));
        $this->assertEquals('CALLBACK!', $container->get('foo'));
    }

    public function testDecoratorThrowsExceptionIfCallbackIsInvalid()
    {
        $this->setExpectedException('InvalidArgumentException');
        $container = new CallbackContainerDecorator(new ArrayContainer, 'foo');
    }
}
