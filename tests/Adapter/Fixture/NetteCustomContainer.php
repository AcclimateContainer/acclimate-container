<?php

namespace Acclimate\Container\Test\Adapter\Fixture;

use Nette\DI\Container;

/**
 * A custom Nette container that defines a service that will throw an exception when accessed from the container
 */
class NetteCustomContainer extends Container
{
    public function createServiceError()
    {
        throw new \RuntimeException();
    }
}
