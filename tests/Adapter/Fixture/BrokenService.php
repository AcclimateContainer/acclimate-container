<?php

namespace Acclimate\Container\Test\Adapter\Fixture;

class BrokenService
{
    public static function factory($config = [])
    {
        throw new \RuntimeException;
    }
}
