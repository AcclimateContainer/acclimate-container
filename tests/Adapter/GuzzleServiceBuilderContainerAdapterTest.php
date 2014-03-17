<?php

namespace Acclimate\Container\Test\Adapter;

use Guzzle\Service\Builder\ServiceBuilder;
use Acclimate\Container\Adapter\GuzzleContainerAdapter;

/**
 * @covers \Acclimate\Container\Adapter\GuzzleContainerAdapter
 */
class GuzzleContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    protected function createAdapter()
    {
        $container = new ServiceBuilder(array(
            'test_service' => array(
                'class'  => __NAMESPACE__ . '\Fixture\MockService',
                'params' => array()
            ),
            'broken_service' => array(
                'class'  => __NAMESPACE__ . '\Fixture\MockBrokenService',
                'params' => array()
            )
        ));

        return new GuzzleContainerAdapter($container);
    }

    public function testSupportsContainerInterface()
    {
        $adapter = $this->createAdapter();

        $this->assertTrue($adapter->has('test_service'));
        $service = $adapter->get('test_service');
        $this->assertInstanceOf('Acclimate\Container\Test\Adapter\Fixture\MockService', $service);
    }

    public function testThrowsExceptionOnNonExistentItem()
    {
        $adapter = $this->createAdapter();

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException(self::NOT_FOUND_EXCEPTION);
        $adapter->get('foo');
    }

    public function testAdapterWrapsOtherExceptions()
    {
        $adapter = $this->createAdapter();

        $this->setExpectedException(self::CONTAINER_EXCEPTION);
        $adapter->get('error');
    }
}
