<?php

namespace Acclimate\Container\Test\Adapter;

abstract class ContainerAdapterTestBase extends \PHPUnit_Framework_TestCase
{
    const CONTAINER_EXCEPTION = 'Interop\Container\Exception\ContainerException';
    const NOT_FOUND_EXCEPTION = 'Interop\Container\Exception\NotFoundException';

    abstract public function testSupportsContainerInterface();

    abstract public function testThrowsExceptionOnNonExistentItem();

    abstract public function testAdapterWrapsOtherExceptions();

    /**
     * @return \Interop\Container\ContainerInterface
     */
    abstract protected function createContainer();
}
