<?php

namespace Acclimate\Container\Test\Adapter\Fixture;

class Circular
{
    public function __construct(Circular $circular)
    {
        $this->circular = $circular;
    }
}
