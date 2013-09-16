<?php

namespace Jeremeamia\Acclimate\Test\Decorator;

use Jeremeamia\Acclimate\Decorator\AbstractContainerDecorator;
use Jeremeamia\Acclimate\ArrayContainer;

class DummyContainerDecorator extends AbstractContainerDecorator {}

/**
 * @covers \Jeremeamia\Acclimate\Decorator\AbstractContainerDecorator
 */
class AbstractContainerDecoratorTest extends \PHPUnit_Framework_TestCase
{
    public function testDecoratorProxiesToContainer()
    {
        $container = new ArrayContainer(['foo' => 'bar']);
        $decorator = new DummyContainerDecorator($container);

        $this->assertTrue($decorator->has('foo'));
        $this->assertEquals('bar', $decorator->get('foo'));
    }
}
