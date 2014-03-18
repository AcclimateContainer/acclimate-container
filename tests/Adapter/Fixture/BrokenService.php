<?php

namespace Acclimate\Container\Test\Adapter\Fixture;

class BrokenService
{
    public static function factory($config = array())
    {
        throw new \RuntimeException;
    }
}
