<?php

namespace Acclimate\Container;

use Acclimate\Api\Container\ContainerInterface;
use Acclimate\Api\Container\NotFoundException;

/**
 * The Array Container is a simple container that follows both the `ContainerInterface` and `ArrayAccess` interface.
 * The container can be seeded with an array or array-like object. The "get" functionality will evaluate closures and
 * cache results.
 */
class ArrayContainer implements ContainerInterface, \ArrayAccess
{
    /**
     * @var array|\ArrayAccess The Container data
     */
    protected $data;

    /**
     * @param array $data Container data
     *
     * @throws \InvalidArgumentException if the provided data is not an array or array-like object
     */
    public function __construct($data = array())
    {
        if (is_array($data) || $data instanceof \ArrayAccess) {
            $this->data = $data;
        } elseif ($data instanceof \Traversable) {
            $this->data = iterator_to_array($data, true);
        } else {
            throw new \InvalidArgumentException('The ArrayContainer requires either an array or an array-like object');
        }
    }

    public function get($identifier)
    {
        if (isset($this->data[$identifier])) {
            return $this[$identifier];
        } else {
            throw new NotFoundException("There is no item in the container for identifier \"{$identifier}\".");
        }
    }

    public function has($identifier)
    {
        return isset($this->data[$identifier]);
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        if ($this->data[$offset] instanceof \Closure) {
            $this->data[$offset] = call_user_func($this->data[$offset], $this);
        }

        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
