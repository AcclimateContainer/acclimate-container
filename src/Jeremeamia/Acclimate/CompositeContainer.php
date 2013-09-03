<?php

namespace Jeremeamia\Acclimate;

class CompositeContainer implements ContainerInterface
{
    /**
     * @var array
     */
    protected $containers;

    /**
     * @param array $containers
     */
    public function __construct(array $containers = array())
    {
        foreach ($containers as $container) {
            $this->addContainer($container);
        }
    }

    /**
     * @param ContainerInterface $container
     *
     * @return self
     */
    public function addContainer(ContainerInterface $container)
    {
        $this->containers[] = $container;

        return $this;
    }

    public function get($name)
    {
        /** @var ContainerInterface $container */
        foreach ($this->containers as $container) {
            if ($container->has($name)) {
                return $container->get($name);
            }
        }

        return null;
    }

    public function has($name)
    {
        /** @var ContainerInterface $container */
        foreach ($this->containers as $container) {
            if ($container->has($name)) {
                return true;
            }
        }

        return false;
    }
}
