<?php

namespace Acclimate\Container\Test\Adapter\Fixture;

/**
 * A dummy class for testing circular references with the Symfony container
 */
class SymfonyRecursiveObject
{
    public function __construct(SymfonyRecursiveObject $circular)
    {
        $this->circular = $circular;
    }
}
