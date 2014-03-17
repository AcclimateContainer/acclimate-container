<?php

namespace Acclimate\Container\Test\Adapter;

use Guzzle\Service\Builder\ServiceBuilder;
use Acclimate\Container\Adapter\GuzzleContainerAdapter;

/**
 * @covers \Acclimate\Container\Adapter\GuzzleContainerAdapter
 */
class GuzzleContainerAdapterTest extends ContainerAdapterTestBase
{
    protected function createContainer()
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
        $container = $this->createContainer();

        $this->assertTrue($container->has('test_service'));
        $service = $container->get('test_service');
        $this->assertInstanceOf('Acclimate\Container\Test\Adapter\Fixture\MockService', $service);
    }

    public function testThrowsExceptionOnNonExistentItem()
    {
        $container = $this->createContainer();

        $this->assertFalse($container->has('foo'));

        $this->setExpectedException(self::NOT_FOUND_EXCEPTION);
        $container->get('foo');
    }

    public function testAdapterWrapsOtherExceptions()
    {
        $container = $this->createContainer();

        $this->setExpectedException(self::CONTAINER_EXCEPTION);
        $container->get('error');
    }
}
