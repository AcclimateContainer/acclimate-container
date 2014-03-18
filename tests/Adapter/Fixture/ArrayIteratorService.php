<?php

namespace Acclimate\Container\Test\Adapter\Fixture;

class ArrayIteratorService
{
    public static function factory($config = array())
    {
        return new \ArrayIterator($config['data']);
    }
}
