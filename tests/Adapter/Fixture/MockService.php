<?php

namespace Jeremeamia\Acclimate\Test\Adapter\Fixture;

class MockService
{
    public static function factory($config = array())
    {
        return new self;
    }
}
