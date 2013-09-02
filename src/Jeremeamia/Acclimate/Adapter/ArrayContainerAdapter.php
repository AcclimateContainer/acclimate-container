<?php

namespace Jeremeamia\Acclimate\Adapter;

class ArrayContainerAdapter extends AbstractContainerAdapter
{
    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (\OutOfBoundsException $e) {
            return $this->handleMissingItem($name, $e);
        }
    }

    public function has($name)
    {
        return $this->container->has($name);
    }

    protected function getExpectedContainerFqcn()
    {
        return 'Jeremeamia\Acclimate\ArrayContainer';
    }
}
