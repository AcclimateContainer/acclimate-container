<?php

namespace Acclimate\Container\Test\Adapter\Fixture;

class MockBrokenService
{
    public static function factory($config = array())
    {
        throw new \RuntimeException;
    }
}
