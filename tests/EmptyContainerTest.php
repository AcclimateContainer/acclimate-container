<?php

namespace Acclimate\Container\Test;


use Acclimate\Container\EmptyContainer;

class EmptyContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiation()
    {
        // when
        $container = EmptyContainer::instance();

        // then
        $this->assertInstanceOf('Interop\Container\ContainerInterface', $container);
    }

    public function testHas()
    {
        // given
        $container = EmptyContainer::instance();

        // when
        $hasFoo = $container->has('foo');

        // then
        $this->assertFalse($hasFoo);
    }

    /**
     * @expectedException \Interop\Container\Exception\NotFoundException
     */
    public function testGet()
    {
        // given
        $container = EmptyContainer::instance();

        // when
        $container->get('foo');

        // then
        $this->fail('unreachable');
    }
}