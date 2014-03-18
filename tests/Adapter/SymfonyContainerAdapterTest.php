<?php

namespace Acclimate\Container\Test\Adapter;

use Acclimate\Container\Adapter\SymfonyContainerAdapter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @covers \Acclimate\Container\Adapter\SymfonyContainerAdapter
 */
class SymfonyContainerAdapterTest extends ContainerAdapterTestBase
{
    protected function createContainer()
    {
        $container = new ContainerBuilder();
        $container->set('array_iterator', new \ArrayIterator(range(1, 5)));

        $definition = new Definition();
        $definition->setClass(__NAMESPACE__ . '\\Fixture\\Circular');
        $definition->addArgument(new Reference('error'));
        $container->setDefinition('error', $definition);

        return new SymfonyContainerAdapter($container);
    }
}
