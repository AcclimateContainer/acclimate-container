<?php

namespace Jeremeamia\Acclimate\Adapter;

class PimpleContainerAdapter extends AbstractContainerAdapter
{
    public function get($name)
    {
        try {
            return $this->container[$name];
        } catch (\InvalidArgumentException $e) {
            return $this->handleMissingItem($name, $e);
        }
    }

    public function has($name)
    {
        return isset($this->container[$name]);
    }
}
