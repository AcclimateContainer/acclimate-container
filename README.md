# Acclimate

* Tagline: Get Acclimated! Adapt service containers to your code.
* Author: [Jeremy Lindblom](https://twitter.com/jeremeamia)
* Version 0.1.0

**Request for Feedback:** Please contact me and let me know what you think about this idea. Thanks.

## Intro

Every framework has its own service container, service locator, service manager, dependency injection container, etc.
Unfortunately, this makes it hard for third-party, framework-agnostic libraries to take advantage of the benefits of
dependency injection systems, because they would need to be dependant on a particular implementation or build in an
abstraction layer to support multiple containers. **Acclimate** is a package that implements the aforementioned
abstraction layer by using the adapter pattern. Using Acclimate allows your library or app to pull data from the
container objects of multiple frameworks.

The Acclimate container interface aims to normalize the various implementations of container interfaces to a concise,
readonly interface, that will allow users to consume data from a variety of different containers in a consistent way.

```php
interface ContainerInterface
{
    public function get($name);
    public function has($name);
}
```

The `Acclimate` object is used to adapt the provided container to the Acclimate container interface.

```php
<?php

require 'vendor/autoload.php';

$acclimate = new Jeremeamia\Acclimate\Acclimate();

$pimple = new Pimple();
$pimple['queue'] = function() {
    $queue = new SplQueue();
    $queue->enqueue('Hello!');
    return $queue;
};

$container = $acclimate->getContainerAdapter($pimple);

$queue = $container->get('queue');
echo $queue->dequeue();
//> Hello!
```

So, use the service container from your favorite framework and acclimate it into your other code. :-)

## Supported Containers

* Acclimate Array Container
* [Aura.Di Container](https://github.com/auraphp/Aura.Di/blob/develop/src/Aura/Di/ContainerInterface.php)
* [Guzzle Service Builder](https://github.com/guzzle/service/blob/master/Builder/ServiceBuilderInterface.php)
* [Pimple](https://github.com/fabpot/Pimple/blob/master/lib/Pimple.php)
* [Symfony Dependency Injection Container](https://github.com/symfony/symfony/blob/master/src/Symfony/Component/DependencyInjection/ContainerInterface.php)
* [ZF2 Service Locator](https://github.com/zendframework/zf2/blob/master/library/Zend/Di/ServiceLocator.php)
* Any object that implements `ArrayAccess`

## Resources

* [Service container usage comparison](https://gist.github.com/mnapoli/6159681)
