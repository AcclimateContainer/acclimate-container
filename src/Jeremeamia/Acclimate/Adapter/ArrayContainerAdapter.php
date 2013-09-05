<?php

namespace Jeremeamia\Acclimate\Adapter;

class ArrayContainerAdapter extends AbstractContainerAdapter
{
    public function get($name)
    {
        try {
            if (isset($this->container[$name])) {
                return $this->container[$name];
            } else {
                $this->handleMissingItem($name);
            }
        } catch (\Exception $e) {
            $this->handleMissingItem($name, $e);
        }
    }

    public function has($name)
    {
        return isset($this->container[$name]);
    }
}
