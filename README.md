# Acclimate

**Get Acclimated!** Adapt third-party service containers to your code.

by [Jeremy Lindblom](https://twitter.com/jeremeamia)

Version 0.1.0

## Introduction

It seems like every framework has its own service container, service locator, service manager, dependency injection (DI)
container, etc. Unfortunately, this makes it hard for third-party, framework-agnostic libraries or apps to take
advantage of the benefits of using a DI system, because they would either need to be dependant on a particular container
implementation or build in an abstraction layer to support multiple containers. **Acclimate** is a package that
implements the aforementioned abstraction layer by using the adapter pattern to adapt the interface of the various
service container implementations to a common, normalized interface. Using Acclimate allows your library or app to
retrieve items from the container objects of third-party frameworks.

## The `ContainerInterface`

The Acclimate container interface attempts to normalize the various implementations of service container interfaces to a
concise, readonly interface, that will allow users to consume data from a variety of different containers in a
consistent way.

The interface supports two methods:

```php
interface ContainerInterface
{
    public function get($name);
    public function has($name);
}
```

The interface also dictates that a `Jeremeamia\Acclimate\ServiceNotFoundException` should be thrown when using `get()`
to retrieve an item that does not actually exist in the container.

## Basic Usage

The `Acclimate` object is used to adapt a service container to the standardized Acclimate container interface.
In terms of design patterns, it's a factory for container adapters.

Here is an example of how to use Acclimate:

```php
<?php

// Require the Composer autoloader
require 'vendor/autoload.php';

use Jeremeamia\Acclimate\Acclimate;

// Create a Pimple container and store an SplQueue object
$pimple = new Pimple();
$pimple['queue'] = function() {
    $queue = new SplQueue();
    $queue->enqueue('Hello!');
    return $queue;
};

// Create an instance of Acclimate and use it to adapt the Pimple container to the Acclimate ContainerInterface
$acclimate = new Acclimate();
$container = $acclimate->adaptContainer($pimple);

// Use the adapted container via the unified interface to fetch the queue object
$queue = $container->get('queue');
echo $queue->dequeue(); // Look! The queue object still works!
#> Hello!
```

Now you can use the service container from your favorite framework and acclimate it into your other code. :-)

## Container Decorators

The default behavior of a container implementing the Acclimate `ContainerInterface` is to throw a `Jeremeamia\Acclimate\ServiceNotFoundException` when using `get()` to retrieve an item that does not actually exist in
the container. In many cases you may want to change this default behavior to do something else instead (e.g., return
`null`). Container decorators allow you to easily modify the behavior of a container. Acclimate ships with only two
decorators (`NullOnMissContainerDecorator` and `CallbackOnMissContainerDecorator`), but allows you to easily create your
own by extending `Jeremeamia\Acclimate\Decorator\AbstractContainerDecorator`.

Here is an example of how to use the `NullOnMissContainerDecorator`:

```php
<?php

// Require the Composer autoloader
require 'vendor/autoload.php';

use Jeremeamia\Acclimate\ArrayContainer;
use Jeremeamia\Acclimate\Decorator\NullOnMissContainerDecorator;
use Jeremeamia\Acclimate\ServiceNotFoundException;

// Create an empty container following the Acclimate ContainerInterface
$container = new ArrayContainer();

// Normally, this container will throw an exception on missing items
try {
    $item = $container->get('foo');
} catch (ServiceNotFoundException $e) {
    echo $e->getMessage() . "\n";
}

// Decorate the container so that null is returned instead of throwing an exception
$container = new NullOnMissContainerDecorator($container);
$item = $container->get('foo');
var_dump($item);
#> NULL
```

## Composite Container

You create composite containers if your use case requires that you need to fetch data from two different container
objects. For the sake of the following example we will say the you have a Symfony `Container` stored in the variable
`$sfContainer` and a Zend `ServiceManager` stored in the variable `$zfContainer`.

```php
use Jeremeamia\Acclimate\Acclimate;
use Jeremeamia\Acclimate\CompositeContainer;

// First, let's acclimate these containers
$acclimate = new Acclimate();
$sfContainer = $acclimate->adaptContainer($sfContainer);
$zfContainer = $acclimate->adaptContainer($zfContainer);

// Now, we will put these two container together
$container = new CompositeContainer([$sfContainer, $zfContainer]);

// When we execute the has() method of the container, it will return true
// if at least one of these containers contains the item
$exists = $container->has('foo');
```

## Supported Containers

* [Aura.Di Container](https://github.com/auraphp/Aura.Di/blob/develop/src/Aura/Di/ContainerInterface.php)
* [Guzzle Service Builder](https://github.com/guzzle/service/blob/master/Builder/ServiceBuilderInterface.php)
* [Laravel Container](https://github.com/laravel/framework/blob/master/src/Illuminate/Container/Container.php)
* [Nette](https://github.com/nette/nette/blob/master/Nette/DI/Container.php)
* [Pimple](https://github.com/fabpot/Pimple/blob/master/lib/Pimple.php)
* [PHP-DI](http://mnapoli.github.io/PHP-DI/)
* [Silex Application](https://github.com/fabpot/Silex/blob/master/src/Silex/Application.php)
* [Symfony Dependency Injection Container](https://github.com/symfony/symfony/blob/master/src/Symfony/Component/DependencyInjection/ContainerInterface.php)
* [ZF2 Service Manager](https://github.com/zendframework/zf2/blob/master/library/Zend/ServiceManager/ServiceLocatorInterface.php)
* [ZF2 Dependency Injection](https://github.com/zendframework/zf2/blob/master/library/Zend/Di/ServiceLocatorInterface.php)
* Any other object that implements `ArrayAccess` ([see PHP Manual](http://php.net/manual/en/class.arrayaccess.php))

## What if the Container I Use is Not Supported?

*Please consider submitting a Pull Request with an adapter for your container and a corresponding test.*

Before you get that point though, you can create the adapter yourself (which is *really* easy to do, just look at the
included ones), and use the `Acclimate::registerAdapter` method to wire up your adapter to Acclimate. You will need to
provide the fully qualified class name (FQCN) of both the adapter class and the base class/interface of the container
you want to be able to adapt.

Assuming that you have a `$container` object that implements `Your\Favorite\ContainerInterface`, and you have written an
adapter class named `Your\Favorite\ContainerAdapter`, here is an example of how you can make these work in Acclimate:

```php
use Jeremeamia\Acclimate\Acclimate;

// Instantiate Acclimate and register your custom adapter
$acclimate = new Acclimate();
$acclimate->registerAdapter('Your\Favorite\ContainerAdapter', 'Your\Favorite\ContainerInterface');

// Use Acclimate to adapt your container
$adaptedContainer = $acclimate->adaptContainer($container);
```

## Resources

* [Service container usage comparison](https://gist.github.com/mnapoli/6159681)

## Projects Using Acclimate

* [XStatic](https://github.com/jeremeamia/xstatic) (jeremeamia/xstatic) - *Static interfaces without the static pitfalls*
