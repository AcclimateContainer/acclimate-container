<?php

namespace Acclimate\Container\Test\Adapter\Fixture;

class MockService
{
    public static function factory($config = array())
    {
        return new self;
    }
}
