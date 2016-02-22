<?php

// @codeCoverageIgnoreStart
/**
 * Default map of container classes to container adapter classes. These are in order of perceived popularity to serve
 * as a minor optimization. `ArrayAccess` is last in the list, since it is used as a fallback if there is no adapter
 * that is a more specific match.
 */
return array(
    'Symfony\Component\DependencyInjection\ContainerInterface' => 'Acclimate\Container\Adapter\SymfonyContainerAdapter',
    'Pimple\Container' => 'Acclimate\Container\Adapter\PimpleContainerAdapter',
    'Zend\ServiceManager\ServiceLocatorInterface' => 'Acclimate\Container\Adapter\ZendServiceManagerContainerAdapter',
    'Zend\Di\LocatorInterface' => 'Acclimate\Container\Adapter\ZendDiContainerAdapter',
    'Illuminate\Container\Container' => 'Acclimate\Container\Adapter\LaravelContainerAdapter',
    'Aura\Di\ContainerInterface' => 'Acclimate\Container\Adapter\AuraContainerAdapter',
    'Guzzle\Service\Builder\ServiceBuilderInterface' => 'Acclimate\Container\Adapter\GuzzleContainerAdapter',
    'DI\Container' => 'Acclimate\Container\Adapter\PHPDIContainerAdapter',
    'Nette\DI\Container' => 'Acclimate\Container\Adapter\NetteContainerAdapter',
    'ArrayAccess' => 'Acclimate\Container\Adapter\ArrayAccessContainerAdapter',
);
// @codeCoverageIgnoreEnd
