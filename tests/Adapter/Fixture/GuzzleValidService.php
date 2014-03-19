<?php

namespace Acclimate\Container\Test\Adapter\Fixture;

/**
 * A valid service that can be retrieved by a Guzzle service builder
 */
class GuzzleValidService
{
    public static function factory($config = [])
    {
        return new \ArrayIterator($config['data']);
    }
}
