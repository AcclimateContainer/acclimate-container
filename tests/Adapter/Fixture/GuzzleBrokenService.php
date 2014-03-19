<?php

namespace Acclimate\Container\Test\Adapter\Fixture;

/**
 * A broken service that will thrown an exception when retrieved by a Guzzle service builder
 */
class GuzzleBrokenService
{
    public static function factory($config = [])
    {
        throw new \RuntimeException;
    }
}
