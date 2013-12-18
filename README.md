# Acclimate Containers

**Get Acclimated!**

Acclimate allows you to third-party containers (e.g., service locators, DICs) in your code by adapting them to a
common interface.

by [Jeremy Lindblom](https://twitter.com/jeremeamia)

Version 0.3.0

-----

## Introduction

It seems like every framework has its own service container, service locator, service manager, dependency injection (DI)
container, etc. Unfortunately, this makes it hard for third-party, framework-agnostic libraries or apps to take
advantage of the benefits of using inversion of control (IoC) systems, because they either need to depend on a
particular container implementation or build in an abstraction layer to support multiple containers. **Acclimate** is a
package that implements the aforementioned abstraction layer, by using the adapter pattern to adapt, or "acclimate" the
interfaces of the various container implementations to a common, normalized interface. Using Acclimate allows your
framework, library, or application to retrieve items from the container objects of third-party frameworks.

## The `ContainerInterface`

The Acclimate `ContainerInterface` attempts to normalize the various implementations of container interfaces (whether
they be for service locators, dependency injection containers, or something else similar) to a simple, readonly
interface, that allows users to retrieve items from a any third-party container in a consistent way.

The `ContainerInterface` is declared in [jeremeamia/acclimate-api](https://github.com/jeremeamia/acclimate-container),
and looks like this:

```php
namespace Acclimate\Api\Container;

interface ContainerInterface
{
    /**
     * @param string $identifier The identifier or name of the item in the container
     * @return mixed
     * @throws NotFoundException If there is no item in the container that matches the provided name
     */
    public function get($identifier);

    /**
     * @param string $identifier The identifier or name of the item in the container
     * @return bool
     */
    public function has($identifier);
}
```

## Basic usage

The `ContainerAcclimator` object is used to adapt a container object to the standardized Acclimate `ContainerInterface`.
In terms of design patterns, it's essentially a factory for container adapters.

Here is an example of how to use the `ContainerAcclimator`:

```php
<?php

// Require the Composer autoloader
require 'vendor/autoload.php';

use Acclimate\Container\ContainerAcclimator;

// Create a `Pimple` container and store an `SplQueue` object in it
$pimple = new Pimple();
$pimple['queue'] = function() {
    $queue = new SplQueue();
    $queue->enqueue('Hello!');
    return $queue;
};

// Create a `ContainerAcclimator` and use it to adapt the `Pimple` container to the Acclimate `ContainerInterface`
$acclimator = new ContainerAcclimator;
$container = $acclimator->acclimate($pimple);

// Use the adapted container via the common interface to fetch the queue object
$queue = $container->get('queue');
echo $queue->dequeue(); // Look! The queue object still works!
#> Hello!
```

Now you can use the container from your favorite framework and acclimate it into your other code. :-)

## Container decorators

The default behavior of a container implementing the Acclimate `ContainerInterface` is to throw an `Acclimate\Api\Container\NotFoundException` when using `get()` to retrieve an item that does not actually exist in
the container. In some cases, you may want to change this default behavior to do something else instead (e.g., return
`null`). Container decorators allow you to easily modify the behavior of a container. `acclimate\container` ships with
only two decorators (`NullOnMissContainer` and `CallbackOnMissContainer`), but allows you to easily
create your own by extending `Acclimate\Container\Decorator\AbstractContainerDecorator`.

Here is an example of how to use the `NullOnMissContainer` decorator:

```php
<?php

// Require the Composer autoloader
require 'vendor/autoload.php';

use Acclimate\Container\ArrayContainer;
use Acclimate\Container\Decorator\NullOnMissContainer;
use Acclimate\Api\Container\NotFoundException;

// Create an empty, basic container following the Acclimate `ContainerInterface`
$container = new ArrayContainer();

// Normally, this container will throw an exception on missing items
try {
    $item = $container->get('foo');
} catch (NotFoundException $e) {
    echo $e->getMessage() . "\n";
}

// Decorate the container so that null is returned instead of throwing an exception
$container = new NullOnMissContainer($container);
$item = $container->get('foo');
var_dump($item);
#> NULL
```

## Composite container

You can create composite containers if your use case requires that you need to fetch data from two or more different
container objects. For the sake of the following example, we will say the you have a Symfony `Container` stored in the
variable `$sfContainer`, and a Zend `ServiceManager` stored in the variable `$zfContainer`.

```php
use Acclimate\Container\ContainerAcclimator;
use Acclimate\Container\CompositeContainer;

// First, let's acclimate these containers
$acclimator = new ContainerAcclimator;
$sfContainer = $acclimator->acclimate($sfContainer);
$zfContainer = $acclimator->acclimate($zfContainer);

// Now, we will put these two containers together
$container = new CompositeContainer([$sfContainer, $zfContainer]);

// When we execute the `has()` method of the container, it will return `true`
// if at least one of these containers contains an item identified by "foo"
$exists = $container->has('foo');
```

## Supported containers

* [Aura.Di Container](https://github.com/auraphp/Aura.Di/blob/develop/src/Aura/Di/ContainerInterface.php)
* [Guzzle Service Builder](https://github.com/guzzle/service/blob/master/Builder/ServiceBuilderInterface.php)
* [Laravel Container](https://github.com/laravel/framework/blob/master/src/Illuminate/Container/Container.php)
* [Nette DI Container](https://github.com/nette/nette/blob/master/Nette/DI/Container.php)
* [Pimple](https://github.com/fabpot/Pimple/blob/master/lib/Pimple.php)
* [PHP-DI Container](https://github.com/mnapoli/PHP-DI/blob/master/src/DI/Container.php)
* [Silex Application](https://github.com/fabpot/Silex/blob/master/src/Silex/Application.php)
* [Symfony Dependency Injection Container](https://github.com/symfony/symfony/blob/master/src/Symfony/Component/DependencyInjection/ContainerInterface.php)
* [ZF2 Service Manager](https://github.com/zendframework/zf2/blob/master/library/Zend/ServiceManager/ServiceLocatorInterface.php)
* [ZF2 Dependency Injection](https://github.com/zendframework/zf2/blob/master/library/Zend/Di/ServiceLocatorInterface.php)
* Any other container-like object that implements `ArrayAccess` (see [`ArrayAccess` in the PHP Manual](http://php.net/manual/en/class.arrayaccess.php))

## What if the Container I use is not supported?

*Please consider submitting a Pull Request with an adapter for your container and a corresponding test.*

Before you get that point though, you can create the adapter yourself (which is *really* easy to do, just look at the
included ones), and use the `ContainerAcclimator::registerAdapter` method to wire up your adapter to Acclimate. You
will need to provide the fully qualified class name (FQCN) of both the adapter class and the base class/interface of the
container you want to be able to adapt (adaptee).

Assuming that you have a `$container` object that implements `Your\Favorite\ContainerInterface`, and you have written an
adapter class named `Your\Favorite\ContainerAdapter`, here is an example of how you can make these work in Acclimate:

```php
use Acclimate\Container\ContainerAcclimator;

// Instantiate the `ContainerAcclimator` and register your custom adapter
$acclimator = new ContainerAcclimator;
$acclimator->registerAdapter('Your\Favorite\ContainerAdapter', 'Your\Favorite\ContainerInterface');

// Use Acclimate to adapt your container
$adaptedContainer = $acclimator->acclimate($container);
```

## Resources

* [Service container usage comparison](https://gist.github.com/mnapoli/6159681)

## Projects Using Acclimate

* [XStatic](https://github.com/jeremeamia/xstatic) (jeremeamia/xstatic) - *Static interfaces without the static pitfalls*
