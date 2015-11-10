<?php

namespace Acclimate\Container\Test;


use Acclimate\Container\ArrayContainer;
use Acclimate\Container\ContainerChain;

class ContainerChainTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateZero()
    {
        // when
        $container = ContainerChain::create(array());

        // then
        $this->assertInstanceOf('Interop\Container\ContainerInterface', $container);
    }

    public function testHasAndGet()
    {
        // given
        $first = new ArrayContainer(array('foo' => 'foo'));
        $second = new ArrayContainer(array('xyz' => 'xyz'));

        // when
        $container = ContainerChain::create(array($first, $second));

        // then
        $this->assertTrue($container->has('foo'));
        $this->assertTrue($container->has('xyz'));
    }

    public function testResponsibilityOrder()
    {
        // given
        $first = new ArrayContainer(array('foo' => 'foo'));
        $second = new ArrayContainer(array('xyz' => 'xyz', 'foo' => 'bar'));

        // when
        $container = ContainerChain::create(array($first, $second));

        // then
        $this->assertEquals($container->get('foo'), 'foo');
        $this->assertEquals($container->get('xyz'), 'xyz');
    }
}