<?php

namespace Jeremeamia\Acclimate\Test;

use Jeremeamia\Acclimate\ArrayContainer;

/**
 * @covers \Jeremeamia\Acclimate\ArrayContainer
 * @covers \Jeremeamia\Acclimate\ServiceNotFoundException
 */
class ArrayContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testCanInstantiateWithArrayOrArrayLikeObject()
    {
        $a1 = array('foo' => 'bar');
        $a2 = new \ArrayObject(array('foo' => 'bar'));
        $a3 = new \LimitIterator(new \ArrayIterator($a1), 0, 1);
        $a4 = 'foo';

        $this->assertInstanceOf('Jeremeamia\Acclimate\ArrayContainer', new ArrayContainer($a1));
        $this->assertInstanceOf('Jeremeamia\Acclimate\ArrayContainer', new ArrayContainer($a2));
        $this->assertInstanceOf('Jeremeamia\Acclimate\ArrayContainer', new ArrayContainer($a3));

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

        $this->setExpectedException('Jeremeamia\Acclimate\ServiceNotFoundException');
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
        $container['name'] = 'Jeremy';
        $container['echo'] = function ($c) {
            return "Hello, {$c['name']}!";
        };

        $this->assertEquals('Hello, Jeremy!', $container['echo']);
    }
}
