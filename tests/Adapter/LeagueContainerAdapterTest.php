<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\LeagueContainerAdapter;
use League\Container\Container;
use RuntimeException;

/**
 * @covers \Acclimate\Container\Adapter\LeagueContainerAdapter
 */
class LeagueContainerAdapterTest extends AbstractContainerAdapterTest
{
    protected function createContainer()
    {
        $container = new Container();

        $container->add('array_iterator', new \ArrayIterator(range(1, 5)));
        $container->add('error', new RuntimeException());

        return new LeagueContainerAdapter($container);
    }
}
