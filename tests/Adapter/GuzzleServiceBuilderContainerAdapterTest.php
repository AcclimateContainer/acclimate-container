<?php

namespace Acclimate\Container\Test\Adapter;

use Guzzle\Service\Builder\ServiceBuilder;
use Acclimate\Container\Adapter\GuzzleContainerAdapter;

/**
 * @covers \Acclimate\Container\Adapter\GuzzleContainerAdapter
 */
class GuzzleContainerAdapterTest extends AbstractContainerAdapterTest
{
    protected function createContainer()
    {
        $container = new ServiceBuilder([
            'array_iterator' => [
                'class'  => __NAMESPACE__ . '\Fixture\GuzzleValidService',
                'params' => ['data' => range(1, 5)],
            ],
            'error' => [
                'class'  => __NAMESPACE__ . '\Fixture\GuzzleBrokenService',
                'params' => [],
            ]
        ]);

        return new GuzzleContainerAdapter($container);
    }
}
