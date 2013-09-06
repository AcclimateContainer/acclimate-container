<?php

namespace Jeremeamia\Acclimate\Test\Adapter;

use Guzzle\Service\Builder\ServiceBuilder;
use Jeremeamia\Acclimate\Adapter\GuzzleContainerAdapter;

/**
 * @covers \Jeremeamia\Acclimate\Adapter\GuzzleContainerAdapter
 */
class GuzzleContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceBuilder
     */
    private $container;

    public function setUp()
    {
        $this->container = new ServiceBuilder(array(
            'test_service' => array(
                'class'  => 'Jeremeamia\Acclimate\Test\Adapter\Fixture\MockService',
                'params' => array()
            )
        ));
    }

    public function testAdapterSupportsContainerInterface()
    {
        $adapter = new GuzzleContainerAdapter($this->container);

        $this->assertTrue($adapter->has('test_service'));
        $service = $adapter->get('test_service');
        $this->assertInstanceOf('Jeremeamia\Acclimate\Test\Adapter\Fixture\MockService', $service);
    }

    public function testAdapterThrowsExceptionOnNonExistentItem()
    {
        $adapter = new GuzzleContainerAdapter($this->container);

        $this->assertFalse($adapter->has('foo'));

        $this->setExpectedException('Jeremeamia\Acclimate\ServiceNotFoundException');
        $adapter->get('foo');
    }
}
