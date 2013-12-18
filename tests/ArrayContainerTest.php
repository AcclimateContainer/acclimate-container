<?php

namespace Acclimate\Container\Test;

use Acclimate\Container\ArrayContainer;

/**
 * @covers \Acclimate\Container\ArrayContainer
 */
class ArrayContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testCanInstantiateWithArrayOrArrayLikeObject()
    {
        $a1 = array('foo' => 'bar');
        $a2 = new \ArrayObject(array('foo' => 'bar'));
        $a3 = new \LimitIterator(new \ArrayIterator($a1), 0, 1);
        $a4 = 'foo';

        $this->assertInstanceOf('Acclimate\Container\ArrayContainer', new ArrayContainer($a1));
        $this->assertInstanceOf('Acclimate\Container\ArrayContainer', new ArrayContainer($a2));
        $this->assertInstanceOf('Acclimate\Container\ArrayContainer', new ArrayContainer($a3));

        $this->setExpectedException('InvalidArgumentException');
        new ArrayContainer($a4);
    }

    public function testContainerSupportsContainerInterface()
    {
        $container = new ArrayContainer(array('array_iterator' => new \ArrayIterator(range(1, 5))));

        $this->assertTrue($container->has('array_iterator'));
        $arrayIterator = $container->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));
    }

    public function testContainerThrowsExceptionOnNonExistentItem()
    {
        $container = new ArrayContainer();

        $this->assertFalse($container->has('foo'));

        $this->setExpectedException('Acclimate\Api\Container\NotFoundException');
        $container->get('foo');
    }

    public function testContainerSupportsArrayAccessInterface()
    {
        $container = new ArrayContainer();
        $this->assertFalse(isset($container['queue']));
        $container['queue'] = new \SplQueue();
        $this->assertTrue(isset($container['queue']));
        $queue = $container['queue'];
        $this->assertInstanceOf('SplQueue', $queue);
        unset($container['queue']);
        $this->assertFalse(isset($container['queue']));
    }

    public function testClosuresAreExecutedOnGet()
    {
        $container = new ArrayContainer();
        $container['foo'] = 'bar';
        $container['baz'] = function ($c) {
            $obj = new \stdClass;
            $obj->foo = $c['foo'];
            return $obj;
        };

        $baz = $container['baz'];
        $this->assertInstanceOf('stdClass', $baz);
        $this->assertEquals('bar', $baz->foo);
        $this->assertSame($baz, $container['baz']);
    }
}
