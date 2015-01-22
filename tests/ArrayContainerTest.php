<?php

namespace Acclimate\Container\Test;

use Acclimate\Container\ArrayContainer;
use Acclimate\Container\Test\Adapter\AbstractContainerAdapterTest;
use Interop\Container\ContainerInterface; 

/**
 * @covers \Acclimate\Container\ArrayContainer
 */
class ArrayContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testCanInstantiateWithArrayOrArrayLikeObject()
    {
        $a1 = ['foo' => 'bar'];
        $a2 = new \ArrayObject(['foo' => 'bar']);
        $a3 = new \LimitIterator(new \ArrayIterator($a1), 0, 1);
        $a4 = 'foo';

        $this->assertInstanceOf('Acclimate\Container\ArrayContainer', new ArrayContainer($a1));
        $this->assertInstanceOf('Acclimate\Container\ArrayContainer', new ArrayContainer($a2));
        $this->assertInstanceOf('Acclimate\Container\ArrayContainer', new ArrayContainer($a3));

        $this->setExpectedException('InvalidArgumentException');
        new ArrayContainer($a4);
    }

    public function testSupportsContainerInterface()
    {
        $container = new ArrayContainer(['array_iterator' => new \ArrayIterator(range(1, 5))]);

        $this->assertTrue($container->has('array_iterator'));
        $arrayIterator = $container->get('array_iterator');
        $this->assertEquals([1, 2, 3, 4, 5], iterator_to_array($arrayIterator));
    }

    public function testThrowsExceptionOnNonExistentItem()
    {
        $container = new ArrayContainer();

        $this->assertFalse($container->has('foo'));

        $this->setExpectedException('Interop\Container\Exception\NotFoundException');
        $container->get('foo');
    }

    public function testAdapterWrapsOtherExceptions()
    {
        $container = new ArrayContainer();
        $container['error'] = function ($c) {
            throw new \RuntimeException;
        };

        $this->setExpectedException('Interop\Container\Exception\ContainerException');
        $container->get('error');
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
    
    public function testDelegateLookupFeature() {
    	$container1 = new ArrayContainer([
    			'foo' => 'bar'
    	]);
    	$container2 = new ArrayContainer([
    			'baz' => function(ContainerInterface $container) {
    				return $container->get('foo');
    			}
    	], $container1);
    	
    	$this->assertEquals('bar', $container2->get('baz'));
    }
}
