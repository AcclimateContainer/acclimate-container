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
            'array_iterator' => array(
                'class'  => __NAMESPACE__ . '\Fixture\ArrayIteratorService',
                'params' => array(
                    'data' => range(1, 5),
                ),
            ),
            'error' => array(
                'class'  => __NAMESPACE__ . '\Fixture\BrokenService',
                'params' => array(),
            )
        ));

        return new GuzzleContainerAdapter($container);
    }
}
