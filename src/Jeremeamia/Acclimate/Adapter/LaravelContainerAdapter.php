<?php

namespace Jeremeamia\Acclimate\Adapter;

class LaravelContainerAdapter extends AbstractContainerAdapter
{
    public function get($name)
    {
        try {
            return $this->container->make($name);
        } catch (\Exception $e) {
            $this->handleMissingItem($name, $e);
        }
    }

    public function has($name)
    {
        return $this->container->bound($name);
    }
}
