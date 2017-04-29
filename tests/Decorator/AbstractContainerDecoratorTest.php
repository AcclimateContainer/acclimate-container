<?php

namespace Acclimate\Container\Test\Decorator;

use Acclimate\Container\Decorator\AbstractContainerDecorator;
use Acclimate\Container\ArrayContainer;
use PHPUnit\Framework\TestCase;

class EnhancedContainer extends AbstractContainerDecorator
{
}

/**
 * @covers \Acclimate\Container\Decorator\AbstractContainerDecorator
 */
class AbstractContainerDecoratorTest extends TestCase
{
    public function testDecoratorProxiesToContainer()
    {
        $container = new ArrayContainer(['foo' => 'bar']);
        $decorator = new EnhancedContainer($container);

        $this->assertTrue($decorator->has('foo'));
        $this->assertEquals('bar', $decorator->get('foo'));
    }
}
