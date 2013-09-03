<?php

namespace Jeremeamia\Acclimate\Test\Adapter;

use Guzzle\Service\Builder\ServiceBuilder;
use Jeremeamia\Acclimate\Adapter\GuzzleServiceBuilderContainerAdapter;

/**
 * @covers \Jeremeamia\Acclimate\Adapter\GuzzleServiceBuilderContainerAdapter
 */
class GuzzleServiceBuilderContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceBuilder
     */
    private $guzzleContainer;

    public function setUp()
    {
        $this->guzzleContainer = new ServiceBuilder(array(
            'test_service' => array(
                'class'  => 'Jeremeamia\Acclimate\Test\Adapter\Fixture\MockService',
                'params' => array()
            )
        ));
    }

    public function testCanCreateAdapter()
    {
        $adapter = new GuzzleServiceBuilderContainerAdapter($this->guzzleContainer);

        $this->assertTrue($adapter->has('test_service'));
        $service = $adapter->get('test_service');
        $this->assertInstanceOf('Jeremeamia\Acclimate\Test\Adapter\Fixture\MockService', $service);

        $this->assertFalse($adapter->has('foo'));
        $this->assertNull($adapter->get('foo'));
    }
}
